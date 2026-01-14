<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GmeBusinessForm;
use App\Models\BusinessCategory;
use App\Mail\BusinessStatusUpdated;
use Illuminate\Support\Facades\Mail;

class GmeBusinessAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $businesses = GmeBusinessForm::select(
                'id',
                'business_name',
                'business_category_id',
                'status',
                'logo',
                'countries_of_operation',
                'created_at'
            )
            ->with('category:id,name')
            ->orderBy('id', 'desc')
            ->get();

            return response()->json([
                'businesses' => $businesses
            ]);
        }

        return view('gme-business-admin.index');
    }
    public function edit($id)
    {
        $business = GmeBusinessForm::findOrFail($id);
        $countries = $this->getCountries();
        $categories = BusinessCategory::orderBy('name')->get();

        return view('gme-business-admin.edit', compact('business', 'countries', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $business = GmeBusinessForm::findOrFail($id);

        $validated = $request->validate([
            // Business Identity
            'business_name'            => 'required|string|max:255',
            'short_introduction'       => 'nullable|string',
            'year_established'         => 'nullable|string',
            'business_category_id'     => 'nullable|exists:business_categories,id',
            'countries_of_operation'   => 'nullable|array',
            'business_address'         => 'nullable|string',
            'email'                    => 'nullable|email|max:255',
            'whatsapp_number'          => 'nullable|string|max:20',
            'website'                  => 'nullable|string|max:255',

            // Social
            'facebook'                 => 'nullable|string|max:255',
            'instagram'                => 'nullable|string|max:255',
            'linkedin'                 => 'nullable|string|max:255',
            'youtube'                  => 'nullable|string|max:255',
            'online_store'             => 'nullable|string|max:255',

            // Founders (JSON)
            'founders'                 => 'nullable|array',

            // Business Size
            'registration_status'      => 'nullable|string',
            'employee_count'           => 'nullable|string',
            'operational_scale'        => 'nullable|string',
            'annual_revenue'           => 'nullable|string',

            // Description
            'business_overview'        => 'nullable|string',
            'services_id'              => 'nullable|array',

            // Ethics
            'avoid_riba'               => 'nullable|string',
            'avoid_haram_products'     => 'nullable|string',
            'fair_pricing'             => 'nullable|string',
            'ethical_description'      => 'nullable|string',
            'open_for_guidance'        => 'nullable|string',

            // Collaboration
            'collaboration_open'       => 'nullable|string',
            'collaboration_types'      => 'nullable|array',

            // Admin
            'status'                   => 'required|in:draft,pending,approved,rejected',

            // Files
            'logo'                     => 'nullable|image|max:2048',
            'registration_document'    => 'nullable|file|max:5120',
            'photos.*'                 => 'nullable|image|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILE UPLOADS
        |--------------------------------------------------------------------------
        */

        // Handle LOGO upload
        if ($request->hasFile('logo')) {
            if ($business->logo && file_exists(public_path('assets/' . $business->logo))) {
                unlink(public_path('assets/' . $business->logo));
            }
            $business->logo = $request->file('logo')
                ->store('uploads/business/logos', 'public_folder');
        }
        
        // Handle COVER PHOTO upload
        if ($request->hasFile('cover_photo')) {
            if ($business->cover_photo && file_exists(public_path('assets/' . $business->cover_photo))) {
                unlink(public_path('assets/' . $business->cover_photo));
            }
            $business->cover_photo = $request->file('cover_photo')
                ->store('uploads/business/covers', 'public_folder');
        }

        // FIX: Handle MULTIPLE PHOTOS (Gallery) - Improved logic
        $existingPhotos = $request->input('existing_photos', []);
        
        // Decode current photos from database if they exist
        $currentPhotos = [];
        if ($business->photos) {
            $currentPhotos = is_array($business->photos) 
                ? $business->photos 
                : json_decode($business->photos, true) ?? [];
        }
        
        // Only keep photos that are in the existing_photos array (user didn't delete them)
        $keptPhotos = [];
        foreach ($currentPhotos as $photo) {
            if (in_array($photo, $existingPhotos)) {
                $keptPhotos[] = $photo;
            } else {
                // Delete removed photos
                if (file_exists(public_path('assets/' . $photo))) {
                    unlink(public_path('assets/' . $photo));
                }
            }
        }
        
        // Add new photos
        $newPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $newPhotos[] = $photo->store('uploads/business/gallery', 'public_folder');
            }
        }
        
        // Merge kept and new photos
        $allPhotos = array_merge($keptPhotos, $newPhotos);
        $business->photos = !empty($allPhotos) ? json_encode($allPhotos) : null;


        // Handle REGISTRATION DOCUMENT upload
        if ($request->hasFile('registration_document')) {
            if ($business->registration_document && file_exists(public_path('assets/' . $business->registration_document))) {
                unlink(public_path('assets/' . $business->registration_document));
            }
            $business->registration_document = $request->file('registration_document')
                ->store('uploads/business/documents', 'public_folder');
        }
        
        // Handle BUSINESS PROFILE upload
        if ($request->hasFile('business_profile')) {
            if ($business->business_profile && file_exists(public_path('assets/' . $business->business_profile))) {
                unlink(public_path('assets/' . $business->business_profile));
            }
            $business->business_profile = $request->file('business_profile')
                ->store('uploads/business/profiles', 'public_folder');
        }
        
        // Handle PRODUCT CATALOGUE upload
        if ($request->hasFile('product_catalogue')) {
            if ($business->product_catalogue && file_exists(public_path('assets/' . $business->product_catalogue))) {
                unlink(public_path('assets/' . $business->product_catalogue));
            }
            $business->product_catalogue = $request->file('product_catalogue')
                ->store('uploads/business/catalogues', 'public_folder');
        }


        $business->update($validated);

        // Check status and send mail
        if (!in_array($business->status, ['draft', 'pending'])) {
            // Prepare data for the mail
            $mailData = [
                'business_name' => $business->business_name,
                'status'        => $business->status,
            ];

            // Send mail (example using a Mailable class)
            $customer = $business->customer;
            Mail::to($customer->email)->send(new BusinessStatusUpdated($mailData));
        }
        

        return redirect()
            ->route('gme-business-admin.index')
            ->with('success', 'Business updated successfully!');
    }
    public function show($id)
    {
        $business = GmeBusinessForm::findOrFail($id);
        return view('gme-business-admin.show', compact('business'));
    }
    public function destroy($id)
    {
        $business = GmeBusinessForm::findOrFail($id);

        if ($business->logo && file_exists(public_path($business->logo))) {
            unlink(public_path($business->logo));
        }

        if ($business->photos) {
            foreach ($business->photos as $photo) {
                if (file_exists(public_path($photo))) {
                    unlink(public_path($photo));
                }
            }
        }

        if ($business->registration_document && file_exists(public_path($business->registration_document))) {
            unlink(public_path($business->registration_document));
        }

        $business->delete();

        return redirect()
            ->route('gme-business-admin.index')
            ->with('success', 'Business deleted successfully!');
    }

    private function getCountries()
    {
        return [
            'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Argentina', 'Armenia', 'Australia',
            'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium',
            'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei',
            'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde',
            'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo',
            'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica',
            'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea',
            'Eritrea', 'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia',
            'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana',
            'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland',
            'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'North Korea',
            'South Korea', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho',
            'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macedonia', 'Madagascar',
            'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius',
            'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique',
            'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger',
            'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea',
            'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda',
            'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino',
            'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone',
            'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan',
            'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria',
            'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia',
            'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom',
            'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam',
            'Yemen', 'Zambia', 'Zimbabwe'
        ];
    }

}
