<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SslCommerzPaymentControllerasdfsad extends Controller
{
    public function pay(Donation $donation)
    {
        $url = config('sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';

        $payload = [
            'store_id'       => config('sslcommerz.store_id'),
            'store_passwd'   => config('sslcommerz.store_password'),
            'total_amount'   => $donation->amount,
            'currency'       => 'BDT',
            'tran_id'        => $donation->transaction_id,

            'success_url' => url(config('sslcommerz.success_url')),
            'fail_url'    => url(config('sslcommerz.fail_url')),
            'cancel_url'  => url(config('sslcommerz.cancel_url')),

            'cus_name'  => auth('donor')->user()->name ?? 'Donor',
            'cus_email' => auth('donor')->user()->email ?? 'donor@mail.com',
            'cus_add1'  => 'Dhaka',
            'cus_city'  => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'cus_phone' => '01700000000',

            'shipping_method' => 'NO',
            'product_name'    => 'Crisis Donation',
            'product_category'=> 'Donation',
            'product_profile' => 'general',
        ];

        $response = Http::asForm()->post($url, $payload)->json();

        if (isset($response['GatewayPageURL']) && $response['GatewayPageURL'] != '') {
            return redirect()->away($response['GatewayPageURL']);
        }

        return back()->with('error', 'Payment gateway error');
    }

    public function success(Request $request)
    {
        $donation = Donation::where('transaction_id', $request->tran_id)->firstOrFail();

        $donation->update([
            'status' => 'success'
        ]);

        return redirect()->route('donor.donations')
            ->with('success', 'Donation payment successful.');
    }

    public function fail(Request $request)
    {
        Donation::where('transaction_id', $request->tran_id)
            ->update(['status' => 'failed']);

        return redirect()->route('donor.donations')
            ->with('error', 'Payment failed.');
    }

    public function cancel(Request $request)
    {
        Donation::where('transaction_id', $request->tran_id)
            ->update(['status' => 'cancelled']);

        return redirect()->route('donor.donations')
            ->with('error', 'Payment cancelled.');
    }
}
