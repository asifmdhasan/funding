<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Crisis;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\HelpseekerPost;

class CrisisViewController extends Controller
{
    // public function frontend()
    // {
    //     // Fetch featured crises (latest 6 or whatever limit you want)
    //     $crises = Crisis::with('category')
    //         ->latest()
    //         ->take(6)
    //         ->get();

    //     // Statistics
    //     $totalCrises = Crisis::count();
    //     $totalDonors = Donor::count();
    //     $totalFunds = Donation::sum('amount');

    //     return view('frontend.index', compact(
    //         'crises',
    //         'totalCrises',
    //         'totalDonors',
    //         'totalFunds'
    //     ));
    // }
    public function frontend()
    {
        // Featured crises
        $crises = Crisis::with('category')
            ->latest()
            ->take(6)
            ->get();
        $posts = HelpseekerPost::with(['helpseeker', 'donations'])
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        // Statistics
        $totalCrises = Crisis::count();
        $totalDonors = Donor::count();
        $totalFunds  = Donation::where('status', 'success')->sum('amount');
        $totalPosts = HelpseekerPost::where('status', 'approved')->count();

        return view('frontend.index', compact(
            'crises',
            'totalCrises',
            'totalDonors',
            'totalFunds',
            'totalPosts',
            'posts'
        ));
    }


    public function index()
    {
        $crises = Crisis::with('category', 'donations')
            ->latest()
            ->take(6)
            ->get();
        // $posts = HelpseekerPost::with(['helpseeker', 'donations'])
        //     ->latest()
        //     ->take(6)
        //     ->get();

        return view('frontend.crises.index', compact('crises'));
    }

    /**
     * Show single crisis details
     */

    public function show($id)
    {
        $crisis = Crisis::findOrFail($id);
        $collected = $crisis->collectedAmount();

        // Decide modal content based on login
        if (auth('donor')->check()) {
            $modalType = 'form'; // show donation form
            $modalData = [
                'max_amount' => $crisis->target_amount - $collected,
            ];
        } else {
            $modalType = 'login'; // show login prompt
            $modalData = [
                'login_route' => route('donor.login'),
            ];
        }

        return view('frontend.crises.show', compact('crisis', 'collected', 'modalType', 'modalData'));
    }

}
