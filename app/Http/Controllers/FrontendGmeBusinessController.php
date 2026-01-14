<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GmeBusinesses;

class FrontendGmeBusinessController extends Controller
{
    public function index(Request $request)
    {
        // Check if it's an AJAX request for JSON data
        if ($request->ajax() || $request->wantsJson()) {
            $businesses = GmeBusinesses::select([
                'id',
                'business_name',
                'tagline',
                'business_category',
                'business_cities',
                'business_countries',
                'founder_name',
                'logo',
                'photos',
                'status',
                'created_at'
            ])
            ->where('allow_publish', true) // Only show businesses that allow publishing
            ->orderBy('created_at', 'desc')
            ->get();

            // Parse JSON fields
            $businesses = $businesses->map(function($business) {
                if ($business->photos && is_string($business->photos)) {
                    $business->photos = json_decode($business->photos, true);
                }
                return $business;
            });

            return response()->json([
                'businesses' => $businesses
            ]);
        }

        // Return the view for normal page load
        return view('gme-business.index');
    }

    public function show($id)
    {
        $business = GmeBusinesses::findOrFail($id);
        return view('gme-business.show', compact('business'));
    }

    public function create()
    {
        return view('gme-business.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        
        $data['info_accuracy'] = $request->has('info_accuracy'); // true/false
        $data['allow_publish'] = $request->has('allow_publish');
        $data['allow_contact'] = $request->has('allow_contact');

        // Handle Uploads
        if ($request->hasFile('registration_document')) {
            $data['registration_document'] = $request->file('registration_document')
            ->store('uploads/registration_document', 'public_folder');
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')
            ->store('uploads/logo', 'public_folder');
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('uploads/business-photos', 'public_folder');
            }
            $data['photos'] = $photos;
        }

        GmeBusinesses::create($data);

        return redirect()->route('gme-business.index')->with('success','Submission successful!');
    }


    public function edit($id)
    {
        $business = GmeBusinesses::findOrFail($id);
        return view('gme-business.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $business = GmeBusinesses::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'founder_email' => 'required|email|max:255',
            'business_category' => 'nullable|string|max:255',
            'business_cities' => 'nullable|string|max:255',
            'business_countries' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'registration_document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->all();

        // Handle checkboxes
        $data['info_accuracy'] = $request->has('info_accuracy');
        $data['allow_publish'] = $request->has('allow_publish');
        $data['allow_contact'] = $request->has('allow_contact');

        // Handle registration document upload
        if ($request->hasFile('registration_document')) {
            // Delete old document if exists
            if ($business->registration_document && file_exists(public_path('assets/docs/' . $business->registration_document))) {
                unlink(public_path('assets/docs/' . $business->registration_document));
            }
            
            $data['registration_document'] = $request->file('registration_document')
                ->store('docs', 'public_folder');
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($business->logo && file_exists(public_path('assets/logo/' . $business->logo))) {
                unlink(public_path('assets/logo/' . $business->logo));
            }
            
            $data['logo'] = $request->file('logo')
                ->store('logo', 'public_folder');
        }

        // Handle photos upload
        if ($request->hasFile('photos')) {
            // Delete old photos if exists
            if ($business->photos && is_array($business->photos)) {
                foreach ($business->photos as $photo) {
                    if (file_exists(public_path('assets/business-photos/' . $photo))) {
                        unlink(public_path('assets/business-photos/' . $photo));
                    }
                }
            }
            
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('business-photos', 'public_folder');
            }
            $data['photos'] = $photos; // Will be automatically cast to JSON
        }

        // Update the business
        $business->update($data);

        return redirect()->route('gme-business.show', $business->id)
            ->with('success', 'Business updated successfully!');
    }
}
