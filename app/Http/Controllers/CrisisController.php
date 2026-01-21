<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Crisis;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;

class CrisisController extends Controller
{
        public function index()
    {
        $crises = Crisis::with('category')->latest()->get();
        return view('crises.index', compact('crises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('crises.create', compact('categories'));
    }

    /**
     * Store a newly created resource.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'category_id'   => 'required|exists:categories,id',
    //         'title'         => 'required|string|max:255',
    //         'description'   => 'nullable|string',
    //         'city'          => 'nullable|string|max:255',
    //         'target_amount' => 'required|numeric|min:1',
    //         'image_url'     => 'nullable|image',
    //     ]);

    //     // Get all validated data
    //     $data = $request->only(['category_id', 'title', 'description', 'city', 'target_amount', 'image_url']);

    //     // Handle IMAGE upload
    //     if ($request->hasFile('image_url')) {
    //         $image = $request->file('image_url');
    //         $imageName = time() . '_' . $image->getClientOriginalName(); 
    //         $image->move(public_path('assets/img/crisis'), $imageName); 
    //         $data['image_url'] = 'assets/img/crisis/' . $imageName;
    //     }

    //     Crisis::create($data);

    //     return redirect()
    //         ->route('crises.index')
    //         ->with('success', 'Crisis created successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'image_url'     => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['category_id', 'title', 'description', 'city', 'target_amount']);

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/img/crisis'), $imageName);
            $data['image_url'] = 'assets/img/crisis/' . $imageName; // THIS is the public path
        }

        Crisis::create($data);

        return redirect()->route('crises.index')->with('success', 'Crisis created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crisis $crisis)
    {
        $categories = Category::all();
        return view('crises.edit', compact('crisis', 'categories'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Crisis $crisis)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'image_url'     => 'nullable|image|max:5120', // allow all images up to 5MB
        ]);

        // Collect all validated data except image
        $data = $request->only(['category_id', 'title', 'description', 'city', 'target_amount']);

        // Handle IMAGE upload
        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($crisis->image_url && file_exists(public_path($crisis->image_url))) {
                unlink(public_path($crisis->image_url));
            }

            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/img/crisis'), $imageName);
            $data['image_url'] = 'assets/img/crisis/' . $imageName; // save new path
        }

        // Update crisis
        $crisis->update($data);

        return redirect()
            ->route('crises.index')
            ->with('success', 'Crisis updated successfully.');
    }


    /**
     * Remove the specified resource.
     */
    public function destroy(Crisis $crisis)
    {
        $crisis->delete();

        return redirect()
            ->route('crises.index')
            ->with('success', 'Crisis deleted successfully.');
    }

    public function show(Crisis $crisis)
    {
        return view('crises.show', compact('crisis'));
    }



    // Show crises analytics
    // public function crisisAnalytics()
    // {
    //     $crises = Crisis::with('donations')->get();
    //     $donors  = Donor::orderBy('name')->get();

    //     return view('crises.analytics', compact('crises', 'donors'));
    // }
    public function crisisAnalytics(Request $request)
    {
        // Get total donations per crisis, excluding null crisis_id
        $crises = Donation::query()
            ->whereNotNull('crisis_id') // exclude null crisis_id
            ->selectRaw('crisis_id, SUM(amount) as total_amount')
            ->with(['crisis.category'])
            ->when($request->crisis_id, function ($q) use ($request) {
                $q->where('crisis_id', $request->crisis_id);
            })
            ->groupBy('crisis_id')
            ->get();

        $crisisList = Crisis::orderBy('title')->get();

        return view('crises.analytics', compact('crises', 'crisisList'));
    }

    public function crisisAnalyticsDetails(Crisis $crisis)
    {
        $donations = Donation::query()
            ->where('crisis_id', $crisis->id)
            ->selectRaw('donor_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
            ->groupBy('donor_id')
            ->with('donor')
            ->get();
            // dd($donations);

        $totalAmount = $donations->sum('total_amount');

        return view('crises.analytics-details', compact(
            'crisis',
            'donations',
            'totalAmount'
        ));
    }







    public function donorReport(Request $request)
    {
        $donors = Donation::query()
            ->selectRaw('donor_id, SUM(amount) as total_amount')
            ->with('donor')
            ->when($request->donor_id, function ($q) use ($request) {
                $q->where('donor_id', $request->donor_id);
            })
            ->groupBy('donor_id')
            ->paginate(10);

        $donorList = Donor::orderBy('name')->get();

        return view('crises.donor-report', compact('donors', 'donorList'));
    }

    /**
     * Donor → crisis breakdown
     */
    // public function donorReportDetails(Donor $donor)
    // {
    //     $donations = Donation::query()
    //         ->where('donor_id', $donor->id)
    //         ->whereNotNull('crisis_id') // exclude null crisis_id
    //         ->selectRaw('crisis_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
    //         ->groupBy('crisis_id')
    //         ->with(['crisis.category'])
    //         ->get();

    //     $totalAmount = $donations->sum('total_amount');

    //     return view('crises.donor-report-details', compact(
    //         'donor',
    //         'donations',
    //         'totalAmount'
    //     ));
    // }
    public function donorReportDetails(Donor $donor)
    {
        // Crisis donations
        $crisisDonations = Donation::query()
            ->where('donor_id', $donor->id)
            ->whereNotNull('crisis_id')
            ->selectRaw('crisis_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
            ->groupBy('crisis_id')
            ->with(['crisis.category'])
            ->get();

        // Helpseeker Post donations
        $helpseekerDonations = Donation::query()
            ->where('donor_id', $donor->id)
            ->whereNotNull('helpseeker_post_id')
            ->selectRaw('helpseeker_post_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
            ->groupBy('helpseeker_post_id')
            ->with(['helpseekerPost.helpseeker'])
            ->get();

        $totalAmount =
            $crisisDonations->sum('total_amount')
            + $helpseekerDonations->sum('total_amount');

        return view('crises.donor-report-details', compact(
            'donor',
            'crisisDonations',
            'helpseekerDonations',
            'totalAmount'
        ));
    }



}
