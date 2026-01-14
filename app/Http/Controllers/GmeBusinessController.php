<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GmeBusinesses;
use App\Models\GmeBusinessForm;
use Illuminate\Support\Facades\Storage;

class GmeBusinessController extends Controller
{


    // public function index(Request $request)
    // {
    //     // If AJAX request → return JSON for DataTables
    //     if ($request->ajax()) {
    //         $businesses = GmeBusinessForm::select(
    //             'id',
    //             'business_name',
    //             'tagline',
    //             'business_category',
    //             'business_cities',
    //             'business_countries',
    //             'founder_name',
    //             'status',
    //             'created_at',
    //             'logo',
    //         )
    //         ->orderBy('id', 'desc')
    //         ->get();

    //         return response()->json([
    //             'businesses' => $businesses
    //         ]);
    //     }

    //     // Normal page load → return Blade view
    //     return view('gme-business-admin.index');
    // }


    // // Add these methods to your GmeBusinessController

    // public function edit($id)
    // {
    //     $business = GmeBusinessForm::findOrFail($id);
    //     return view('gme-business-admin.edit', compact('business'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $business = GmeBusinessForm::findOrFail($id);
    //     // dd($business);
        
    //     // Validation rules
    //     $rules = [
    //         'business_name' => 'required|string|max:255',
    //         'founder_name' => 'required|string|max:255',
    //         'founder_email' => 'required|email|max:255',
    //         'tagline' => 'nullable|string|max:255',
    //         'year_established' => 'nullable|string|max:4',
    //         'business_category' => 'nullable|string|max:255',
    //         'business_countries' => 'nullable|string|max:255',
    //         'business_cities' => 'nullable|string|max:255',
    //         'business_address' => 'nullable|string',
    //         'founder_whatsapp' => 'nullable|string|max:20',
    //         'website' => 'nullable|url|max:255',
    //         'facebook' => 'nullable|url|max:255',
    //         'instagram' => 'nullable|url|max:255',
    //         'linkedin' => 'nullable|url|max:255',
    //         'youtube' => 'nullable|url|max:255',
    //         'online_store' => 'nullable|url|max:255',
    //         'contact_person_name' => 'nullable|string|max:255',
    //         'contact_person_role' => 'nullable|string|max:255',
    //         'contact_person_email' => 'nullable|email|max:255',
    //         'contact_person_phone' => 'nullable|string|max:20',
    //         'registration_status' => 'nullable|string|max:50',
    //         'employee_count' => 'nullable|string|max:50',
    //         'operational_scale' => 'nullable|string|max:50',
    //         'annual_revenue' => 'nullable|string|max:50',
    //         'business_overview' => 'nullable|string',
    //         'status' => 'required|in:pending,approved,rejected',
    //         'registration_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',

    //         'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'avoid_riba' => 'nullable|string',
    //         'avoid_haram_products' => 'nullable|string',
    //         'fair_pricing' => 'nullable|string',
    //         'ethical_description' => 'nullable|string',
    //         'open_for_guidance' => 'nullable|string',
    //         'collaboration_open' => 'nullable|string',
    //     ];
        
    //     $validated = $request->validate($rules);
        
    //     // UPDATE LOGO
    //     if ($request->hasFile('logo')) {

    //         // Delete old file
    //         if ($business->logo && file_exists(public_path($business->logo))) {
    //             unlink(public_path($business->logo));
    //         }

    //         // Store new file same as create()
    //         $validated['logo'] = $request->file('logo')
    //             ->store('uploads/logo', 'public_folder');
    //     }


    //     // UPDATE REGISTRATION DOCUMENT
    //     if ($request->hasFile('registration_document')) {

    //         if ($business->registration_document && file_exists(public_path($business->registration_document))) {
    //             unlink(public_path($business->registration_document));
    //         }

    //         $validated['registration_document'] = $request->file('registration_document')
    //             ->store('uploads/registration_document', 'public_folder');
    //     }


    //     // UPDATE MULTIPLE PHOTOS
    //     if ($request->hasFile('photos')) {

    //         // Optional: delete old photos
    //         if ($business->photos) {
    //             foreach ($business->photos as $oldPhoto) {
    //                 if (file_exists(public_path($oldPhoto))) {
    //                     unlink(public_path($oldPhoto));
    //                 }
    //             }
    //         }

    //         $photos = [];
    //         foreach ($request->file('photos') as $photo) {
    //             $photos[] = $photo->store('uploads/business-photos', 'public_folder');
    //         }

    //         $validated['photos'] = $photos;
    //     }

        
    //     // Update the business
    //     $business->update($validated);
        
    //     return redirect()
    //         ->route('gme-business-admin.index', $business->id)
    //         ->with('success', 'Business updated successfully!');
    // }

    // public function show($id)
    // {
    //     $business = GmeBusinessForm::findOrFail($id);
    //     return view('gme-business-admin.show', compact('business'));
    // }

    // public function destroy($id)
    // {
    //     $business = GmeBusinessForm::findOrFail($id);
        
    //     // Delete associated files
    //     if ($business->logo && file_exists(public_path($business->logo))) {
    //         unlink(public_path($business->logo));
    //     }
        
    //     if ($business->photos) {
    //         foreach ($business->photos as $photo) {
    //             if (file_exists(public_path($photo))) {
    //                 unlink(public_path($photo));
    //             }
    //         }
    //     }
        
    //     $business->delete();
        
    //     return redirect()
    //         ->route('gme-business-admin.index')
    //         ->with('success', 'Business deleted successfully!');
    // }












    
}
