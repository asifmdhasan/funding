@extends('layouts.frontend-master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">GME Business Enlistment Form</h2>

    <form action="{{ route('gme-business.store') }}" method="POST" enctype="multipart/form-data" id="gmeForm">
        @csrf

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
                    <input type="text" name="business_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Year Established</label>
                    <input type="text" name="year_established" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label>Tagline</label>
                <input type="text" name="tagline" class="form-control">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Business Category *</label>
                    <select name="business_category" class="form-control">
                        <option>Technology</option>
                        <option>Food & Beverage</option>
                        <option>Fashion</option>
                        <option>Education</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Business Countries</label>
                    <select name="business_countries" class="form-control">
                        <option>Bangladesh</option>
                        <option>Japan</option>
                        <option>Canada</option>
                        <option>Germany</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Business Cities</label>
                    <select name="business_cities" class="form-control">
                        <option>Dhaka</option>
                        <option>Tokyo</option>
                        <option>Toronto</option>
                        <option>Berlin</option>
                    </select>
                </div>
            </div>

            
        </div>

        <!-- STEP 2 -->
        <div class="form-step d-none">
            <h4>Step 2: Personal Information</h4>
            {{-- <div class="mb-3">
                
            </div> --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Full Name *</label>
                    <input type="text" name="founder_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Email Address *</label>
                    <input type="email" name="founder_email" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Phone Number/WhatsApp *</label>
                    <input type="text" name="founder_whatsapp" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Facebook Profile</label>
                    <input type="url" name="facebook" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Website</label>
                    <input type="url" name="website" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Instagram</label>
                    <input type="url" name="instagram" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>LinkedIn Profile</label>
                    <input type="url" name="linkedin" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>YouTube Channel</label>
                    <input type="url" name="youtube" class="form-control">
                </div>
                 <div class="col-md-4">
                    <label>Online Store</label>
                    <input type="url" name="online_store" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Contact Person Name</label>
                    <input type="text" name="contact_person_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Contact Person Role</label>
                    <select name="contact_person_role" class="form-control">
                        <option value="">Select Role</option>
                        <option>Founder</option>
                        <option>CEO</option>
                        <option>Business Development Manager</option>
                        <option>Marketing Manager</option>
                        <option>Operations Manager</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Contact Person Email</label>
                    <input type="email" name="contact_person_email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Contact Person Phone</label>
                    <input type="text" name="contact_person_phone" class="form-control">
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
                        <option>Registered Company</option>
                        <option>Sole Proprietorship</option>
                        <option>Partnership</option>
                        <option>Startup (Early Stage)</option>
                        <option>Home-Based</option>
                        <option>Not Registered Yet</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Number of Employees</label>
                    <select name="employee_count" class="form-control">
                        <option>1–3</option>
                        <option>4–10</option>
                        <option>11–25</option>
                        <option>26–50</option>
                        <option>51+</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Operational Scale</label>
                    <select name="operational_scale" class="form-control">
                        <option>Local</option>
                        <option>Nationwide</option>
                        <option>International</option>
                        <option>Online Only</option>
                        <option>Hybrid</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Annual Revenue Range</label>
                    <select name="annual_revenue" class="form-control">
                        <option>Under $10K</option>
                        <option>$10K–$50K</option>
                        <option>$50K–$200K</option>
                        <option>$200K–$1M</option>
                        <option>Above $1M</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Upload Registration / License Documents</label>
                <input type="file" name="registration_document" class="form-control">
            </div>
        </div>

        <!-- STEP 4 -->
        <div class="form-step d-none">
            <h4>Step 4: Business Description</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Upload Business Logo</label>
                    <input type="file" name="logo" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Upload Business Photos (Max 5)</label>
                    <input type="file" name="photos[]" class="form-control" multiple>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Business Overview (Max 500 words)</label>
                    <textarea name="business_overview" class="form-control" rows="10"></textarea>
                </div>
                <div class="col-md-6">
                    <label>Products/Services (Max 500 words)</label>
                    <textarea name="products" class="form-control" rows="10"></textarea>
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
                        <option>Yes</option>
                        <option>Partially (transitioning)</option>
                        <option>No</option>
                        <option>Prefer not to say</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Does your business avoid prohibited products/services?</label>
                    <select name="avoid_haram_products" class="form-control">
                        <option>Yes</option>
                        <option>Partially compliant</option>
                        <option>No</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Do you practice fair pricing (i.e. charging customers a price that is reflective of the value of the product or service)?</label>
                    <select name="fair_pricing" class="form-control">
                        <option>Yes</option>
                        <option>No</option>
                        <option>Partially compliant</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Are you open for guidance on Islamic ethical alignment?</label>
                    <select name="open_for_guidance" class="form-control">
                        <option>Yes</option>
                        <option>No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Ethical Description</label>
                <textarea name="ethical_description" class="form-control"></textarea>
            </div>
        </div>

        <!-- STEP 6 -->
        <div class="form-step d-none">
            <h4>Step 6: Collaboration & Community</h4>
            <div class="mb-3">
                <label>Are you open for collaborations within GME Network?</label>
                <select name="collaboration_open" class="form-control">
                    <option>Yes</option>
                    <option>No</option>
                    <option>Maybe</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Types of Collaboration Interested In:</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Partnerships">
                    <label class="form-check-label">Partnerships</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Investment Opportunities">
                    <label class="form-check-label">Investment Opportunities</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="collaboration_types[]" value="Marketing/Promotion">
                    <label class="form-check-label">Marketing/Promotion</label>
                </div>
            </div>
        </div>

        <!-- STEP 7 -->
        <div class="form-step d-none">
            <h4>Step 7: Consent & Approval</h4>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="info_accuracy" value="1" checked required>
                <label class="form-check-label">I confirm that all information provided is accurate</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="allow_publish" value="1" checked required>
                <label class="form-check-label">I authorize GME to publish my business profile</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="allow_contact" value="1" checked required>
                <label class="form-check-label">I agree GME may contact me for verification</label>
            </div>
            <div class="mb-3 mt-3">
                <label>Digital Signature</label>
                <input type="text" name="digital_signature" class="form-control">
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
    document.getElementById("nextBtn").innerHTML = n == (steps.length - 1) ? "Submit" : "Next";

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
