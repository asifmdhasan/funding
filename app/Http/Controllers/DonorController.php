<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Donor;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{
    public function register()
    {
        return view('frontend.donors.register');
    }

    /**
     * Store new donor
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:donors,email',
            'password'              => 'required|min:6|confirmed',
        ]);

        Donor::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('donor.login')
            ->with('success', 'Registration successful. Please login.');
    }

    /**
     * Show donor login form
     */
    public function login()
    {
        return view('frontend.donors.login');
    }

    /**
     * Authenticate donor
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('donor')->attempt($request->only('email', 'password'))) {
            return redirect()->route('crisis.list');
        }

        return back()->with('error', 'Invalid credentials');
    }

    /**
     * Logout donor
     */
    public function logout()
    {
        Auth::guard('donor')->logout();

        return redirect()->route('donor.login');
    }

    public function profile()
    {
        $donor = auth('donor')->user();
        return view('frontend.donors.profile', compact('donor'));
    }
    // Update donor profile
    public function updateProfile(Request $request)
    {
        $donor = auth('donor')->user();
        $donor->update($request->all());
        return redirect()->route('donor.profile')->with('success', 'Profile updated successfully');
    }

    // public function donations()
    // {
    //     $donations = Donation::with('crisis')
    //         ->where('donor_id', auth('donor')->id())
    //         ->latest()
    //         ->get();

    //     return view('frontend.donation.index', compact('donations'));
    // }
    public function donations(Request $request)
    {
        $type = $request->get('type', 'crisis'); // default crisis

        $query = Donation::where('donor_id', auth('donor')->id())
            ->where('status', 'success')
            ->latest();

        if ($type === 'help') {
            $query->whereNotNull('helpseeker_post_id')
                ->with(['helpseekerPost.helpseeker']);
        } else {
            $query->whereNotNull('crisis_id')
                ->with('crisis');
        }

        $donations = $query->get();

        return view('frontend.donation.index', compact('donations', 'type'));
    }


    public function printDonations()
    {
        $donor = auth('donor')->user();
        $donations = Donation::with('crisis')
            ->where('donor_id', $donor->id)
            ->whereNotNull('crisis_id')
            ->where('status', 'success')
            ->latest()
            ->get();

        $totalAmount = $donations->sum('amount');

        // Load Blade view as HTML
        $html = view('frontend.donation.pdf', compact('donor', 'donations', 'totalAmount'))->render();

        // Create PDF
        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->WriteHTML($html);

        // Output PDF (force download)
        return $mpdf->Output("My_Donations_{$donor->name}.pdf", 'I');
        // return $mpdf->Output("My_Donations_{$donor->name}.pdf", 'D');
    }
    public function printHelpPostDonations()
    {
        $donor = auth('donor')->user();

        $donations = Donation::with(['helpseekerPost.helpseeker'])
            ->where('donor_id', $donor->id)
            ->whereNotNull('helpseeker_post_id')
            ->where('status', 'success')
            ->latest()
            ->get();

        $totalAmount = $donations->sum('amount');

        // Load Blade view as HTML
        $html = view('frontend.donation.pdf-help', compact('donor', 'donations', 'totalAmount'))->render();

        // Create PDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->WriteHTML($html);

        // Output PDF in browser
        return $mpdf->Output("My_HelpPost_Donations_{$donor->name}.pdf", 'I');
    }


    

}
