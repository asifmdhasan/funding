@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit GME Business - {{ $business->business_name }}</h2>

    <form action="{{ route('gme-business.update', $business->id) }}" method="POST" enctype="multipart/form-data" id="gmeForm">
        @csrf
        @method('PUT')

        <!-- Step Progress -->
        <div class="progress mb-4">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 14%;" id="formProgress">Step 1 of 7</div>
        </div>

        <!-- STEP 1 -->
        <div class="form-step">
            <h4>Step 1: Business Identity</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Business Name *</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $business->business_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label>Year Established</label>
                    <input type="text" name="year_established" class="form-control" value="{{ old('year_established', $business->year_established) }}">
                </div>
            </div>
            <div class="mb-3">
                <label>Tagline</label>
                <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $business->tagline) }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Business Category *</label>
                    <select name="business_category" class="form-control">
                        <option value="Technology" {{ old('business_category', $business->business_category) == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Food & Beverage" {{ old('business_category', $business->business_category) == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                        <option value="Fashion" {{ old('business_category', $business->business_category) == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Education" {{ old('business_category', $business->business_category) == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Finance" {{ old('business_category', $business->business_category) == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Healthcare" {{ old('business_category', $business->business_category) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Consulting" {{ old('business_category', $business->business_category) == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                        <option value="Design & Media" {{ old('business_category', $business->business_category) == 'Design & Media' ? 'selected' : '' }}>Design & Media</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Business Countries</label>
                    <select name="business_countries" class="form-control">
                        <option value="Bangladesh" {{ old('business_countries', $business->business_countries) == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                        <option value="Japan" {{ old('business_countries', $business->business_countries) == 'Japan' ? 'selected' : '' }}>Japan</option>
                        <option value="Canada" {{ old('business_countries', $business->business_countries) == 'Canada' ? 'selected' : '' }}>Canada</option>
                        <option value="Germany" {{ old('business_countries', $business->business_countries) == 'Germany' ? 'selected' : '' }}>Germany</option>
                        <option value="UAE" {{ old('business_countries', $business->business_countries) == 'UAE' ? 'selected' : '' }}>UAE</option>
                        <option value="Malaysia" {{ old('business_countries', $business->business_countries) == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                        <option value="UK" {{ old('business_countries', $business->business_countries) == 'UK' ? 'selected' : '' }}>UK</option>
                        <option value="Turkey" {{ old('business_countries', $business->business_countries) == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                        <option value="Australia" {{ old('business_countries', $business->business_countries) == 'Australia' ? 'selected' : '' }}>Australia</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Business Cities</label>
                    <select name="business_cities" class="form-control">
                        <option value="Dhaka" {{ old('business_cities', $business->business_cities) == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                        <option value="Tokyo" {{ old('business_cities', $business->business_cities) == 'Tokyo' ? 'selected' : '' }}>Tokyo</option>
                        <option value="Toronto" {{ old('business_cities', $business->business_cities) == 'Toronto' ? 'selected' : '' }}>Toronto</option>
                        <option value="Berlin" {{ old('business_cities', $business->business_cities) == 'Berlin' ? 'selected' : '' }}>Berlin</option>
                        <option value="Dubai" {{ old('business_cities', $business->business_cities) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                        <option value="Kuala Lumpur" {{ old('business_cities', $business->business_cities) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="London" {{ old('business_cities', $business->business_cities) == 'London' ? 'selected' : '' }}>London</option>
                        <option value="Istanbul" {{ old('business_cities', $business->business_cities) == 'Istanbul' ? 'selected' : '' }}>Istanbul</option>
                        <option value="Sydney" {{ old('business_cities', $business->business_cities) == 'Sydney' ? 'selected' : '' }}>Sydney</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- STEP 2 -->
        <div class="form-step d-none">
            <h4>Step 2: Personal Information</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Full Name *</label>
                    <input type="text" name="founder_name" class="form-control" value="{{ old('founder_name', $business->founder_name) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Email Address *</label>
                    <input type="email" name="founder_email" class="form-control" value="{{ old('founder_email', $business->founder_email) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Phone Number/WhatsApp *</label>
                    <input type="text" name="founder_whatsapp" class="form-control" value="{{ old('founder_whatsapp', $business->founder_whatsapp) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Facebook Profile</label>
                    <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $business->facebook) }}">
                </div>
                <div class="col-md-4">
                    <label>Website</label>
                    <input type="url" name="website" class="form-control" value="{{ old('website', $business->website) }}">
                </div>
                <div class="col-md-4">
                    <label>Instagram</label>
                    <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $business->instagram) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>LinkedIn Profile</label>
                    <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $business->linkedin) }}">
                </div>
                <div class="col-md-4">
                    <label>YouTube Channel</label>
                    <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $business->youtube) }}">
                </div>
                 <div class="col-md-4">
                    <label>Online Store</label>
                    <input type="url" name="online_store" class="form-control" value="{{ old('online_store', $business->online_store) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Contact Person Name</label>
                    <input type="text" name="contact_person_name" class="form-control" value="{{ old('contact_person_name', $business->contact_person_name) }}">
                </div>
                <div class="col-md-6">
                    <label>Contact Person Role</label>
                    <select name="contact_person_role" class="form-control">
                        <option value="">Select Role</option>
                        <option value="Founder" {{ old('contact_person_role', $business->contact_person_role) == 'Founder' ? 'selected' : '' }}>Founder</option>
                        <option value="CEO" {{ old('contact_person_role', $business->contact_person_role) == 'CEO' ? 'selected' : '' }}>CEO</option>
                        <option value="Business Development Manager" {{ old('contact_person_role', $business->contact_person_role) == 'Business Development Manager' ? 'selected' : '' }}>Business Development Manager</option>
                        <option value="Marketing Manager" {{ old('contact_person_role', $business->contact_person_role) == 'Marketing Manager' ? 'selected' : '' }}>Marketing Manager</option>
                        <option value="Operations Manager" {{ old('contact_person_role', $business->contact_person_role) == 'Operations Manager' ? 'selected' : '' }}>Operations Manager</option>
                        <option value="Other" {{ old('contact_person_role', $business->contact_person_role) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Contact Person Email</label>
                    <input type="email" name="contact_person_email" class="form-control" value="{{ old('contact_person_email', $business->contact_person_email) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Contact Person Phone</label>
                    <input type="text" name="contact_person_phone" class="form-control" value="{{ old('contact_person_phone', $business->contact_person_phone) }}">
                </div>
            </div>
        </div>

        <!-- STEP 3 -->
        <div class="form-step d-none">
            <h4>Step 3: Business Size & Structure</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Registration Status </label>
                    <select name="registration_status" class="form-control">
                        <option value="Registered Company" {{ old('registration_status', $business->registration_status) == 'Registered Company' ? 'selected' : '' }}>Registered Company</option>
                        <option value="Sole Proprietorship" {{ old('registration_status', $business->registration_status) == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                        <option value="Partnership" {{ old('registration_status', $business->registration_status) == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                        <option value="Startup (Early Stage)" {{ old('registration_status', $business->registration_status) == 'Startup (Early Stage)' ? 'selected' : '' }}>Startup (Early Stage)</option>
                        <option value="Home-Based" {{ old('registration_status', $business->registration_status) == 'Home-Based' ? 'selected' : '' }}>Home-Based</option>
                        <option value="Not Registered Yet" {{ old('registration_status', $business->registration_status) == 'Not Registered Yet' ? 'selected' : '' }}>Not Registered Yet</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Number of Employees</label>
                    <select name="employee_count" class="form-control">
                        <option value="1–3" {{ old('employee_count', $business->employee_count) == '1–3' ? 'selected' : '' }}>1–3</option>
                        <option value="4–10" {{ old('employee_count', $business->employee_count) == '4–10' ? 'selected' : '' }}>4–10</option>
                        <option value="11–25" {{ old('employee_count', $business->employee_count) == '11–25' ? 'selected' : '' }}>11–25</option>
                        <option value="26–50" {{ old('employee_count', $business->employee_count) == '26–50' ? 'selected' : '' }}>26–50</option>
                        <option value="51+" {{ old('employee_count', $business->employee_count) == '51+' ? 'selected' : '' }}>51+</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Operational Scale</label>
                    <select name="operational_scale" class="form-control">
                        <option value="Local" {{ old('operational_scale', $business->operational_scale) == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Nationwide" {{ old('operational_scale', $business->operational_scale) == 'Nationwide' ? 'selected' : '' }}>Nationwide</option>
                        <option value="International" {{ old('operational_scale', $business->operational_scale) == 'International' ? 'selected' : '' }}>International</option>
                        <option value="Online Only" {{ old('operational_scale', $business->operational_scale) == 'Online Only' ? 'selected' : '' }}>Online Only</option>
                        <option value="Hybrid" {{ old('operational_scale', $business->operational_scale) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Annual Revenue Range</label>
                    <select name="annual_revenue" class="form-control">
                        <option value="Under $10K" {{ old('annual_revenue', $business->annual_revenue) == 'Under $10K' ? 'selected' : '' }}>Under $10K</option>
                        <option value="$10K–$50K" {{ old('annual_revenue', $business->annual_revenue) == '$10K–$50K' ? 'selected' : '' }}>$10K–$50K</option>
                        <option value="$50K–$200K" {{ old('annual_revenue', $business->annual_revenue) == '$50K–$200K' ? 'selected' : '' }}>$50K–$200K</option>
                        <option value="$200K–$1M" {{ old('annual_revenue', $business->annual_revenue) == '$200K–$1M' ? 'selected' : '' }}>$200K–$1M</option>
                        <option value="Above $1M" {{ old('annual_revenue', $business->annual_revenue) == 'Above $1M' ? 'selected' : '' }}>Above $1M</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Upload Registration / License Documents</label>
                @if($business->registration_document)
                    <div class="alert alert-info">
                        Current file: <a href="{{ asset('assets/docs/' . $business->registration_document) }}" target="_blank">View Document</a>
                    </div>
                @endif
                <input type="file" name="registration_document" class="form-control">
                <small class="text-muted">Leave empty to keep current document</small>
            </div>
        </div>

        <!-- STEP 4 -->
        <div class="form-step d-none">
            <h4>Step 4: Business Description</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Upload Business Logo</label>
                    @if($business->logo)
                        <div class="mb-2">
                            <img src="{{ asset('assets/logo/' . $business->logo) }}" alt="Current Logo" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control">
                    <small class="text-muted">Leave empty to keep current logo</small>
                </div>
                <div class="col-md-6">
                    <label>Upload Business Photos (Max 5)</label>
                    @if($business->photos && count($business->photos) > 0)
                        <div class="mb-2 d-flex gap-2 flex-wrap">
                            @foreach($business->photos as $photo)
                                <img src="{{ asset('assets/business-photos/' . $photo) }}" alt="Business Photo" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="photos[]" class="form-control" multiple>
                    <small class="text-muted">Leave empty to keep current photos, or upload new ones to replace</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Business Overview (Max 500 words)</label>
                    <textarea name="business_overview" class="form-control" rows="10">{{ old('business_overview', $business->business_overview) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Products/Services (Max 500 words)</label>
                    <textarea name="products" class="form-control" rows="10">{{ old('products', is_array($business->products) ? json_encode($business->products) : $business->products) }}</textarea>
                </div>
            </div>
        </div>

        <!-- STEP 5 -->
        <div class="form-step d-none">
            <h4>Step 5: Islamic Ethical Alignment</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Do you avoid interest-based (riba) financing?</label>
                    <select name="avoid_riba" class="form-control">
                        <option value="Yes" {{ old('avoid_riba', $business->avoid_riba) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="Partially (transitioning)" {{ old('avoid_riba', $business->avoid_riba) == 'Partially (transitioning)' ? 'selected' : '' }}>Partially (transitioning)</option>
                        <option value="No" {{ old('avoid_riba', $business->avoid_riba) == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Prefer not to say" {{ old('avoid_riba', $business->avoid_riba) == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Does your business avoid prohibited products/services?</label>
                    <select name="avoid_haram_products" class="form-control">
                        <option value="Yes" {{ old('avoid_haram_products', $business->avoid_haram_products) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="Partially compliant" {{ old('avoid_haram_products', $business->avoid_haram_products) == 'Partially compliant' ? 'selected' : '' }}>Partially compliant</option>
                        <option value="No" {{ old('avoid_haram_products', $business->avoid_haram_products) == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Do you practice fair pricing?</label>
                    <select name="fair_pricing" class="form-control">
                        <option value="Yes" {{ old('fair_pricing', $business->fair_pricing) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('fair_pricing', $business->fair_pricing) == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Partially compliant" {{ old('fair_pricing', $business->fair_pricing) == 'Partially compliant' ? 'selected' : '' }}>Partially compliant</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Are you open for guidance on Islamic ethical alignment?</label>
                    <select name="open_for_guidance" class="form-control">
                        <option value="Yes" {{ old('open_for_guidance', $business->open_for_guidance) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('open_for_guidance', $business->open_for_guidance) == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Ethical Description</label>
                <textarea name="ethical_description" class="form-control">{{ old('ethical_description', $business->ethical_description) }}</textarea>
            </div>
        </div>

        <!-- STEP 6 -->
        <div class="form-step d-none">
            <h4>Step 6: Collaboration & Community</h4>
            <div class="mb-3">
                <label>Are you open for collaborations within GME Network?</label>
                <select name="collaboration_open" class="form-control">
                    <option value="Yes" {{ old('collaboration_open', $business->collaboration_open) == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ old('collaboration_open', $business->collaboration_open) == 'No' ? 'selected' : '' }}>No</option>
                    <option value="Maybe" {{ old('collaboration_open', $business->collaboration_open) == 'Maybe' ? 'selected' : '' }}>Maybe</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Types of Collaboration Interested In:</label><br>
                @php
                    $collaborationTypes = old('collaboration_types', $business->collaboration_types ?? []);
                @endphp
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Partnerships" {{ in_array('Partnerships', $collaborationTypes) ? 'checked' : '' }}>
                    <label class="form-check-label">Partnerships</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Investment Opportunities" {{ in_array('Investment Opportunities', $collaborationTypes) ? 'checked' : '' }}>
                    <label class="form-check-label">Investment Opportunities</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Marketing/Promotion" {{ in_array('Marketing/Promotion', $collaborationTypes) ? 'checked' : '' }}>
                    <label class="form-check-label">Marketing/Promotion</label>
                </div>
            </div>
        </div>

        <!-- STEP 7 -->
        <div class="form-step d-none">
            <h4>Step 7: Consent & Approval</h4>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="info_accuracy" value="1" {{ old('info_accuracy', $business->info_accuracy) ? 'checked' : '' }} required>
                <label class="form-check-label">I confirm that all information provided is accurate</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="allow_publish" value="1" {{ old('allow_publish', $business->allow_publish) ? 'checked' : '' }} required>
                <label class="form-check-label">I authorize GME to publish my business profile</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="allow_contact" value="1" {{ old('allow_contact', $business->allow_contact) ? 'checked' : '' }} required>
                <label class="form-check-label">I agree GME may contact me for verification</label>
            </div>
            <div class="mb-3 mt-3">
                <label>Digital Signature</label>
                <input type="text" name="digital_signature" class="form-control" value="{{ old('digital_signature', $business->digital_signature) }}">
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" class="btn btn-warning" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>

    </form>
</div>

<script>
let currentStep = 0;
showStep(currentStep);

function showStep(n) {
    let steps = document.getElementsByClassName("form-step");
    steps[n].classList.remove("d-none");

    document.getElementById("prevBtn").style.display = n == 0 ? "none" : "inline";
    document.getElementById("nextBtn").innerHTML = n == (steps.length - 1) ? "Update" : "Next";

    // Progress bar
    let progress = ((n+1)/steps.length)*100;
    document.getElementById("formProgress").style.width = progress + "%";
    document.getElementById("formProgress").innerText = `Step ${n+1} of 7`;
}

function nextPrev(n) {
    let steps = document.getElementsByClassName("form-step");

    // Validate required fields
    let valid = true;
    if (n == 1) {
        let inputs = steps[currentStep].querySelectorAll("input, select, textarea");
        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
                break;
            }
        }
    }

    if (!valid) return false;

    steps[currentStep].classList.add("d-none");
    currentStep += n;

    if (currentStep >= steps.length) {
        document.getElementById("gmeForm").submit();
        return false;
    }

    showStep(currentStep);
}
</script>
@endsection