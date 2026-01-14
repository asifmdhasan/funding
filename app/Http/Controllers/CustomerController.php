<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GmeBusinessForm;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function customerProfile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|unique:customers,phone,' . $customer->id,
            'dob' => 'nullable|date',
            'profile_image' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = $request->only(['name', 'email', 'phone', 'dob']);

        // Handle profile image
        if ($request->hasFile('profile_image')) {

            // Delete old file if exists
            if ($customer->profile_image && file_exists(public_path($customer->profile_image))) {
                unlink(public_path($customer->profile_image));
            }

            // Upload new file to public/assets/uploads/customer-images
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/uploads/customer-images'), $filename);

            // Add to $data so it updates DB
            $data['profile_image'] = 'assets/uploads/customer-images/' . $filename;
        }

        $customer->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(){
        return view('customer.update-password');
    }

    public function storeUpdatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $customer = Auth::guard('customer')->user();

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');

    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }




    /////////////////////GET CUSTOMER DASHBOARD/////////////////////
    public function customerDashboard()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.dashboard', compact('customer'));
    }

    public function createGmeBusinessForm(){
        return view('customer.gme-business.create');
    }


    //Here serve customer budiness Index
    public function gmeBusinessIndex()
    {
        return view('gme-business.index');
    }
    public function indexAjax(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return response()->json([], 401);
        }

        $businesses = GmeBusinessForm::query()
            ->select([
                'id',
                'customer_id',
                'business_name',
                'short_introduction',
                'business_category_id',
                'countries_of_operation',
                'founders',
                'logo',
                'photos',
                'status',
                'created_at',
            ])
            ->with('category:id,name')
            ->where('customer_id', $customer->id)
            ->orderByDesc('id')
            ->get()
            ->transform(function ($business) {
                $business->photos = is_string($business->photos)
                    ? json_decode($business->photos, true)
                    : ($business->photos ?? []);

                $business->founders = is_string($business->founders)
                    ? json_decode($business->founders, true)
                    : ($business->founders ?? []);

                return $business;
            });

        return response()->json([
            'businesses' => $businesses
        ]);
    }


    public function getCategoryAjax()
    {
        $categories = BusinessCategory::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function getLocationAjax()
    {
        return response()->json([
            'locations' => $this->getCountries()
        ]);
    }


    // public function show($id)
    // {
    //     $business = GmeBusinessForm::findOrFail($id);
    //     return view('gme-business.show', compact('business'));
    // }
public function show($id)
{
    $business = GmeBusinessForm::with('category.services')->findOrFail($id);

    // Decode services_id JSON
    $selectedServiceIds = $business->services_id ?? [];
    if (is_string($selectedServiceIds)) {
        $selectedServiceIds = json_decode($selectedServiceIds, true);
    }

    // Filter category services based on selected IDs
    $services = $business->category
        ? $business->category->services->whereIn('id', $selectedServiceIds)
        : collect();

    return view('gme-business.show', compact('business', 'services'));
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
