<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\GmeBusinessForm;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerPasswordResetMail;

class CustomerAuthController extends Controller
{

    public function showCustomerLoginForm()
    {
        
        return view('customer.auth.login');
    }

    public function cusLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email'           => $request->email,
            'password'        => $request->password,
            'status'          => 1,
            'is_otp_verified' => 1,
        ];

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('customer.gme-business-form.index');
        }

        return redirect()->back()->withErrors([
            'email' => __('login.login_failed'),
        ]);
    }


    // public function cusLogin(Request $request)
    // {
    //     $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     // Use the correct guard
    //     if (Auth::guard('customer')->attempt($credentials)) {

    //         $customer = Auth::guard('customer')->user();

    //         return redirect()->route('customer.dashboard');
    //     }

    //     return redirect()->back()->withErrors([
    //         'email' => __('login.login_failed'),
    //     ]);
    // }


    // ============================
    // SHOW REGISTER FORM
    // ============================
    // public function showRegisterForm()
    // {
    //     return view('customer.auth.register');
    // }
    // public function showRegisterForm(Request $request)
    // {
    //     $step = $request->get('step', 1);
    //     $user = auth()->user(); // Authenticated user
        
    //     // Get or create business for this user
    //     $business = GmeBusinessForm::firstOrCreate(
    //         ['user_id' => $user->id, 'status' => 'draft'],
    //         ['user_id' => $user->id]
    //     );
        
    //     $categories = BusinessCategory::all();
    //     $countries = $this->getCountriesList();
        
    //     return view('gme.business.register', compact('step', 'business', 'categories', 'countries'));
    // }

    // ============================
    // REGISTER
    // ============================
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:customers',
            'phone'    => 'nullable|string|unique:customers',
            'password' => 'required|min:6',
            'dob'      => 'nullable|date',
        ]);

        $otp = rand(100000, 999999);

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'dob'      => $request->dob,
            'password' => Hash::make($request->password),
            'otp'             => $otp,
            'otp_expires_at'  => now()->addMinutes(3),
            'status'          => 0,
        ]);

        // Send OTP via Email (example)
        Mail::raw("Your OTP is: {$otp}", function ($message) use ($customer) {
            $message->to($customer->email)
                    ->subject('OTP Verification');
        });

        return redirect()
            ->route('customer.reg.otp.form', $customer->id)
            ->with('success', 'OTP sent to your email.');

        return redirect()->route('customer.login')->with('success', 'Registration successful! Please login.');
    }

    public function verifyRegOtp(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'otp'         => 'required|digits:6',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        // OTP mismatch
        if ($customer->otp !== $request->otp) {
            return back()->withErrors([
                'otp' => 'Invalid OTP'
            ]);
        }

        // OTP expired
        if ($customer->otp_expires_at && $customer->otp_expires_at->isPast()) {
            return back()->withErrors([
                'otp' => 'OTP has expired'
            ]);
        }

        // Clear OTP after success
        $customer->update([
            'otp' => null,
            'otp_expires_at' => null,
            'status' => 1,
            'is_otp_verified' => 1,
        ]);

        return redirect()
            ->route('customer.login')
            ->with('success', 'Registration successful! Please login.');
    }

    // ============================
    // SHOW FORGOT PASSWORD FORM
    // ============================
    public function showForgetPasswordForm()
    {
        return view('customer.auth.forgot-password');
    }


    // ============================
    // SEND OTP
    // ============================
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        $otp = rand(100000, 999999);

        $customer->update([
            'otp'             => $otp,
            'otp_expires_at'  => Carbon::now()->addMinutes(10)
        ]);

        // Send email
        Mail::to($customer->email)->send(new CustomerPasswordResetMail($otp));
        // Mail::raw("Your OTP is: $otp", function ($msg) use ($customer) {
        //     $msg->to($customer->email)->subject('Password Reset OTP');
        // });

        // return redirect()->route('customer.verify.otp')->with('success', 'OTP sent to your email.');
        return redirect()->route('customer.verify.otp')->with([
            'success' => 'OTP sent to your email.',
            'email' => $request->email
        ]);

    }


    // ============================
    // SHOW VERIFY OTP FORM
    // ============================
    public function showVerifyOtpForm()
    {
        if (!session('email')) {
            return redirect()->route('customer.forgot.password')
                ->withErrors(['email' => 'Session expired. Try again.']);
        }

        return view('customer.auth.verify-otp', [
            'email' => session('email')
        ]);
    }



    // ============================
    // VERIFY OTP
    // ============================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        if ($customer->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        if (Carbon::now()->greaterThan($customer->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired']);
        }

        return redirect()->route('customer.reset.password')->with([
            'success' => 'OTP verified. Please reset password.',
            'email'   => $request->email
        ]);
    }


    // ============================
    // SHOW RESET PASSWORD FORM
    // ============================
    public function showResetPasswordForm()
    {
        return view('customer.auth.reset-password');
    }


    // ============================
    // RESET PASSWORD
    // ============================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            // 'otp'      => 'required',
            'password' => 'required|min:6',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        // if ($customer->otp !== $request->otp) {
        //     return back()->withErrors(['otp' => 'Invalid OTP']);
        // }

        $customer->update([
            'password'        => Hash::make($request->password),
            'otp'             => null,
            'otp_expires_at'  => null,
            'is_otp_verified' => 1,
            'status'          => 1,
        ]);

        return redirect()->route('customer.login')->with('success', 'Password reset successful!');
    }

    public function cusLogout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }


    // ============================ Dashboard ============================
    public function customerDashboard()
    {
        Auth::guard('customer')->user();
        return view('customer.dashboard');
    }
}
