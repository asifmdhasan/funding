<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\GmeBusinessForm;

use App\Models\BusinessCategory;
use App\Mail\BusinessCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendBusinessCreationEmailJob;

class GmeRegController extends Controller
{
    //FOR ALL

    // public function businessIndexCustomer(Request $request)
    // {
    //     $customer = auth()->guard('customer')->user();

    //     if (!$customer) {
    //         return redirect()->route('customer.login')->with('error', 'Please login first.');
    //     }

    //     // Check if it's an AJAX request for JSON data
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $businesses = GmeBusinessForm::select([
    //                 'id',
    //                 'business_name',
    //                 'short_introduction',
    //                 'business_category_id',
    //                 'countries_of_operation',
    //                 'founders',
    //                 'logo',
    //                 'photos',
    //                 'status',
    //                 'created_at'
    //             ])
    //             ->with('category')
    //             ->where('customer_id', $customer->id) // Only his own businesses
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         // Parse JSON fields
    //         $businesses = $businesses->map(function($business) {
    //             if ($business->photos && is_string($business->photos)) {
    //                 $business->photos = json_decode($business->photos, true);
    //             }
    //             return $business;
    //         });

    //         return response()->json([
    //             'businesses' => $businesses
    //         ]);
    //     }

    //     // Return the view for normal page load
    //     return view('customer.gme-business.index-own', [
    //         'customer' => $customer
    //     ]);
    // }

    public function showRegisterForm(Request $request)
    {
        $step = $request->get('step', 1);
        // $customer = session('customer');
        $customer = auth()->guard('customer')->user(); 
        
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Please login first');
        }
        
        // Check if draft exists
        $business = GmeBusinessForm::where('customer_id', $customer->id)
            ->where('status', 'draft')
            ->first();
        
        // If no draft exists, create a blank object (not saved yet)
        if (!$business) {
            $business = new GmeBusinessForm();
            $business->customer_id = $customer->id;
            $business->status = 'draft';
        }
        
        $categories = BusinessCategory::all();
        $countries = $this->getCountries();
        
        return view('gme-reg.register', compact('step', 'business', 'categories', 'countries'));
    }

    public function getServices($categoryId)
    {
        return response()->json(
            Service::where('business_category_id', $categoryId)
                ->select('id', 'name')
                ->get()
        );
    }

    public function saveStep(Request $request)
    {
        $step = $request->input('step');
        $customer = auth()->guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Session expired. Please login again.');
        }
        
        // Validation
        $validator = $this->validateStep($request, $step);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Find existing draft or create new
        $business = GmeBusinessForm::where('customer_id', $customer->id)
            ->where('status', 'draft')
            ->first();
        
        if (!$business) {
            $business = new GmeBusinessForm();
            $business->customer_id = $customer->id;
            $business->status = 'draft';
        }
        
        // Save data based on step
        switch ($step) {
            case 1:
                $this->saveStep1($request, $business);
                break;
            case 2:
                $this->saveStep2($request, $business);
                break;
            case 3:
                $this->saveStep3($request, $business);
                break;
            case 4:
                $this->saveStep4($request, $business);
                break;
        }
        
        $business->last_updated_step = $step;
        $business->save();
        
        // If final step, change status to pending
        if ($step == 4) {
            $business->status = 'pending';
            $business->save();

            // Send email to customer for creation of business  
            // BusinessCreatedMail::dispatch($business);
            Mail::to($customer->email)->send(new BusinessCreatedMail($business));

            
            return redirect()->route('gme.business.success')
                ->with('success', 'Your business has been successfully registered!');
        }
        
        // Move to next step
        $nextStep = $step + 1;
        return redirect()->route('gme.business.register', ['step' => $nextStep])
            ->with('success', 'Step ' . $step . ' saved successfully!');
    }

    /**
     * Validate step data
     */
    private function validateStep(Request $request, $step)
    {
        $rules = [];
        
        switch ($step) {
            case 1:
                $rules = [
                    'business_name' => 'required|string|max:255',
                    'short_introduction' => 'nullable|string',
                    'year_established' => 'nullable|string',
                    'business_category_id' => 'required|exists:business_categories,id',
                    'countries_of_operation' => 'required|array|min:1',
                    'business_address' => 'nullable|string',
                    'email' => 'required|email',
                    'whatsapp_number' => 'nullable|string|max:20',
                    'website' => 'nullable|string|max:255',
                    'facebook' => 'nullable|string|max:255',
                    'instagram' => 'nullable|string|max:255',
                    'linkedin' => 'nullable|string|max:255',
                    'youtube' => 'nullable|string|max:255',
                    'online_store' => 'nullable|string|max:255',
                    'founders' => 'required|array|min:1',
                    'founders.*.name' => 'required|string',
                    'founders.*.designation' => 'required|string',
                    'founders.*.whatsapp' => 'nullable|string',
                    'founders.*.linkedin' => 'nullable|string|max:255',
                ];
                break;
                
            case 2:
                $rules = [
                    'registration_status' => 'required|in:registered_company,sole_proprietorship,partnership,startup_early_stage,home_based,not_registered_yet',
                    'employee_count' => 'required|in:1-3,4-10,11-25,26-50,51+',
                    'operational_scale' => 'required|in:local,nationwide,international,online_only,hybrid',
                    'annual_revenue' => 'nullable|in:under_10k,10k-50k,50k-200k,200k-1m,above_1m',
                    'business_overview' => 'nullable|string|max:1800',
                    'services_id' => 'required|array|max:10',
                    'services_id.*' => 'exists:services,id',

                    // Documents + Images
                    'registration_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp,avif|max:5120',
                    'business_profile'      => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp,avif|max:5120',
                    'product_catalogue'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp,avif|max:5120',

                    // Images only (all image types)
                    'logo'                  => 'nullable|image|max:2048',
                    'cover_photo'           => 'nullable|image|max:5120',
                    'photos.*'              => 'nullable|image|max:5120',
    
                    // 'registration_document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                    // 'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                    // 'cover_photo' => 'nullable|image|max:5120',
                    // 'photos.*' => 'nullable|image|max:5120',
                    // 'business_profile' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                    // 'product_catalogue' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                ];
                break;
                
            case 3:
                $rules = [
                    'avoid_riba' => 'required|in:yes,partially_transitioning,no,prefer_not_to_say',
                    'avoid_haram_products' => 'required|in:yes,partially_compliant,no',
                    'fair_pricing' => 'required|in:yes,mostly,needs_improvement',
                    'ethical_description' => 'nullable|string|max:1200',
                    'open_for_guidance' => 'required|in:yes,no,maybe',
                    'collaboration_open' => 'required|in:yes,no,maybe',
                    'collaboration_types' => 'nullable|array',
                    // 'collaboration_types.*' => 'in:Partnerships,Investment Opportunities,Marketing,Supply Chain,Training', // Updated values

                    'collaboration_types.*' => 'in:Partnerships,Investment Oportunities,Vendor Supply Chain,Marketing Promotion,Networking,Training Workshops,Community Charity Projects,Not Sure Yet',
                ];
                break;
                
            case 4:
                $rules = [
                    'info_accuracy' => 'required|accepted',
                    'allow_publish' => 'nullable|boolean',
                    'allow_contact' => 'required|accepted',
                    'digital_signature' => 'required|string',
                ];
                break;
        }
        
        return Validator::make($request->all(), $rules);
    }

    /**
     * Save Step 1 data
     */
    private function saveStep1(Request $request, GmeBusinessForm $business)
    {
        $business->business_name = $request->business_name;
        $business->short_introduction = $request->short_introduction;
        $business->year_established = $request->year_established;
        $business->business_category_id = $request->business_category_id;
        $business->countries_of_operation = json_encode($request->countries_of_operation);
        $business->business_address = $request->business_address;
        $business->email = $request->email;
        $business->whatsapp_number = $request->whatsapp_number;
        $business->website = $request->website;
        $business->facebook = $request->facebook;
        $business->instagram = $request->instagram;
        $business->linkedin = $request->linkedin;
        $business->youtube = $request->youtube;
        $business->online_store = $request->online_store;
        
        // Save founders as JSON
        $business->founders = json_encode($request->founders);
    }

    /**
     * Save Step 2 data
     */

    private function saveStep2(Request $request, GmeBusinessForm $business)
    {
        $business->registration_status = $request->registration_status;
        $business->employee_count = $request->employee_count;
        $business->operational_scale = $request->operational_scale;
        $business->annual_revenue = $request->annual_revenue;
        $business->business_overview = $request->business_overview;
        
        // FIX: Save services_id properly
        $business->services_id = $request->services_id ? json_encode($request->services_id) : null;
        
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
    }

    /**
     * Save Step 3 data
     */
    private function saveStep3(Request $request, GmeBusinessForm $business)
    {
        $business->avoid_riba = $request->avoid_riba;
        $business->avoid_haram_products = $request->avoid_haram_products;
        $business->fair_pricing = $request->fair_pricing;
        $business->ethical_description = $request->ethical_description;
        $business->open_for_guidance = $request->open_for_guidance;
        $business->collaboration_open = $request->collaboration_open;
        $business->collaboration_types = json_encode($request->collaboration_types ?? []);
    }

    /**
     * Save Step 4 data
     */
    private function saveStep4(Request $request, GmeBusinessForm $business)
    {
        $business->info_accuracy = $request->has('info_accuracy');
        $business->allow_publish = $request->has('allow_publish');
        $business->allow_contact = $request->has('allow_contact');
        $business->digital_signature = $request->digital_signature;
        $business->status = 'pending'; // Set to pending for admin approval
    }

    /**
     * Success page
     */
    public function success()
    {
        return view('gme-reg.success');
    }

    /**
     * Get list of countries (helper method)
     */
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
