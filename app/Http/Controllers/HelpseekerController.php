<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Helpseeker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class HelpseekerController extends Controller
{
    // public function index()
    // {
    //     $helpseekers = Helpseeker::latest()->paginate(10);
    //     return view('helpseekers.index', compact('helpseekers'));
    // }


    public function showRegisterForm()
    {
        return view('frontend.helpseeker.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:helpseekers,email',
            'password'        => 'required|string|min:6|confirmed',
            'phone'           => 'nullable|string|max:20',
            'city'            => 'nullable|string|max:255',
        ]);

        Helpseeker::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'phone'           => $request->phone,
            'city'            => $request->city,
        ]);

        return redirect()->route('helpseeker.login')->with('success', 'Registration successful. Wait for admin approval.');
    }

    // ===============================
    // Helpseeker Login (Frontend)
    // ===============================
    public function showLoginForm()
    {
        return view('frontend.helpseeker.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth('helpseeker')->attempt($credentials)) {
            $request->session()->regenerate();

            // // Only approved helpseekers can login
            // if (auth('helpseeker')->user()->status !== 'approved') {
            //     auth('helpseeker')->logout();
            //     return back()->withErrors(['email' => 'Your account is not approved yet.']);
            // }

            return redirect()->route('helpseeker.posts.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }




    // ===============================
    // Helpseeker Report for admin
    // ===============================
    public function report()
    {
        $helpseekers = Donation::query()
            ->selectRaw('helpseeker_id, SUM(amount) as total_received')
            ->where('status', 'success')
            ->with('helpseeker')
            ->groupBy('helpseeker_id')
            ->paginate(10);

        return view('reports.helpseeker-report', compact('helpseekers'));
    }

    // ===============================
    // Report details
    // ===============================
    public function reportDetails(Helpseeker $helpseeker)
    {
        $donations = Donation::where('helpseeker_id', $helpseeker->id)
            ->with('donor')
            ->get();

        $totalAmount = $donations->sum('amount');

        return view('reports.helpseeker-report-details', compact('helpseeker', 'donations', 'totalAmount'));
    }


    // public function dashboard()
    // {
    //     $helpseeker = auth('helpseeker')->user();
    //     $donations = $helpseeker->donations()->with('donor')->get();

    //     return view('frontend.helpseeker.dashboard', compact('helpseeker', 'donations'));
    // }

    public function dashboard()
    {
        $helpseeker = auth('helpseeker')->user();

        // Get all posts of this helpseeker
        $posts = $helpseeker->posts()->latest()->get(); // Assuming 'posts()' relation

        return view('frontend.helpseeker.dashboard', compact('helpseeker', 'posts'));
    }

    public function profile()
    {
        $helpseeker = auth('helpseeker')->user();
        return view('helpseekers.edit', compact('helpseeker'));
    }

    // // ===============================
    // // Helpseeker Profile Update
    // // ===============================
    public function profileUpdate(Request $request)
    {
        $helpseeker = auth('helpseeker')->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:helpseekers,email,' . $helpseeker->id,
            'password' => 'nullable|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:255',
        ]);

        $helpseeker->name = $request->name;
        $helpseeker->email = $request->email;
        if ($request->filled('password')) {
            $helpseeker->password = Hash::make($request->password);
        }
        $helpseeker->phone = $request->phone;
        $helpseeker->city = $request->city;
        $helpseeker->save();

        return redirect()->route('helpseeker.posts.index')->with('success', 'Profile updated successfully.');
    }
    // ===============================
    // Helpseeker Logout
    // ===============================



    // public function edit(Helpseeker $helpseeker)
    // {
    //     return view('helpseekers.edit', compact('helpseeker'));
    // }

    // ===============================
    // Admin: Update helpseeker
    // ===============================
    // public function update(Request $request, Helpseeker $helpseeker)
    // {
    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:helpseekers,email,' . $helpseeker->id,
    //         'password' => 'nullable|string|min:6|confirmed',
    //         'phone'    => 'nullable|string|max:20',
    //         'city'     => 'nullable|string|max:255',
    //     ]);

    //     $helpseeker->name = $request->name;
    //     $helpseeker->email = $request->email;
    //     if ($request->filled('password')) {
    //         $helpseeker->password = Hash::make($request->password);
    //     }
    //     $helpseeker->phone = $request->phone;
    //     $helpseeker->city = $request->city;

    //     $helpseeker->save();

    //     return redirect()->route('helpseekers.dashboard')->with('success', 'Helpseeker updated successfully.');
    // }

    public function logout(Request $request)
    {
        auth('helpseeker')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('helpseeker.login');
    }
}
