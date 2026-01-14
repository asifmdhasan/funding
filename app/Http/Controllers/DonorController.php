<?php

namespace App\Http\Controllers;

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

    public function donations()
    {
        $donations = Donation::with('crisis')
            ->where('donor_id', auth('donor')->id())
            ->latest()
            ->get();

        return view('frontend.donation.index', compact('donations'));
    }



}
