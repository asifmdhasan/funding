<?php

namespace App\Http\Controllers;

use App\Models\Crisis;
use App\Models\Donation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HelpseekerPost;

class DonationController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'crisis_id' => 'required|exists:crises,id',
            'amount'    => 'required|numeric|min:1',
        ]);


        $crisis = Crisis::findOrFail($request->crisis_id);

        // total collected
        $totalCollected = $crisis->donations()
            ->where('status', 'success')
            ->sum('amount');

        // amount validation (target er beshi jabe na)
        if (($totalCollected + $request->amount) > $crisis->target_amount) {
            return back()->with('error', 'Donation exceeds target amount');
        }
        
        $donation = Donation::create([
            'crisis_id'     => $crisis->id,
            'donor_id'      => auth('donor')->id(),
            'amount'        => $request->amount,
            'transaction_id'=> Str::uuid(),
            'status'        => 'pending',
        ]);
        // return redirect()->route('payment.ssl.pay', $donation->id);
    

        // 👉 SSLCommerz redirect ekhane hobe
        // $this->sslPayment($donation);

        // return redirect()->route('payment.process', $donation->id);
        return redirect()->route('donor.donations')->with('success', 'Donation successfully completed.');
    }

    public function helppostStore(Request $request)
    {
        $request->validate([
            'helpseeker_post_id' => 'required|exists:helpseeker_posts,id',
            'amount'             => 'required|numeric|min:1',
        ]);

        // Find the Help Post
        $post = HelpseekerPost::findOrFail($request->helpseeker_post_id);

        // Total collected amount for this post
        $totalCollected = $post->donations()
            ->where('status', 'success')
            ->sum('amount');

        // Check if donation exceeds required_amount
        if (($totalCollected + $request->amount) > $post->required_amount) {
            return back()->with('error', 'Donation exceeds the required amount for this post.');
        }

        // Create donation
        $donation = Donation::create([
            'helpseeker_post_id' => $post->id,
            'donor_id'           => auth('donor')->id(),
            'amount'             => $request->amount,
            'transaction_id'     => Str::uuid(),
            'status'             => 'success',
        ]);

        // Optionally: redirect to payment process if you use SSLCommerz
        // $this->sslPayment($donation);

        return redirect()->route('donor.donations')->with('success', 'Donation successfully completed.');
    }


    //paymentSuccess
    public function paymentSuccess()
    {
        return view('frontend.donation.success');
    }
    /**
     * Payment success callback
     */
    public function success(Request $request)
    {
        Donation::where('transaction_id', $request->tran_id)
            ->update(['status' => 'success']);

        return view('frontend.donation.success');
    }

    /**
     * Payment failed
     */
    public function fail(Request $request)
    {
        Donation::where('transaction_id', $request->tran_id)
            ->update(['status' => 'failed']);

        return view('frontend.donation.failed');
    }
}
