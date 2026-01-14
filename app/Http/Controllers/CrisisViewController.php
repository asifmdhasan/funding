<?php

namespace App\Http\Controllers;

use App\Models\Crisis;
use Illuminate\Http\Request;

class CrisisViewController extends Controller
{
    public function index()
    {
        $crises = Crisis::with('category', 'donations')
            ->latest()
            ->get();

        return view('frontend.crises.index', compact('crises'));
    }

    /**
     * Show single crisis details
     */
    // public function show($id)
    // {
    //     $crisis = Crisis::with('category', 'donations')
    //         ->findOrFail($id);

    //     return view('frontend.crises.show', compact('crisis'));
    // }
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
