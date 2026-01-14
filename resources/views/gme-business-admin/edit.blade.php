@extends('layouts.master')

@section('content')
<style>
    /* Fixed width for labels so all buttons align */
    .question-label {
        display: inline-block;
        width: 220px; /* Adjust width as needed */
        margin-bottom: 0;
    }
    .btn-outline-secondary {
        min-width: 140px;
        text-align: center;
    }
    #pageLoader {
        transition: opacity 0.2s ease;
    }
</style>
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('gme-business-admin.update', $business->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Step 1: Business Identity --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">Step 1: Business Identity</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Business Name <span class="text-danger">*</span></label>
                        <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $business->business_name) }}" required>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label>Year Established</label>
                        <input type="text" name="year_established" class="form-control" value="{{ old('year_established', $business->year_established) }}">
                    </div>
                    {{-- <div class="col-md-6 form-group">
                        <label>Business Category</label>
                        <input type="text" name="business_category_id" class="form-control" value="{{ old('business_category_id', $business->category->name) }}">
                    </div> --}}
                    <div class="col-md-6 form-group">
                        <label>Business Category</label>

                        <select name="business_category_id"
                                class="form-control @error('business_category_id') is-invalid @enderror">
                            <option value="">Select Category</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('business_category_id', $business->business_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('business_category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="form-label">Countries of Operation *</label>
                        
                        @php
                            // Ensure $savedCountries is always an array
                            $savedCountries = old(
                                'countries_of_operation',
                                is_array($business->countries_of_operation)
                                    ? $business->countries_of_operation
                                    : (is_string($business->countries_of_operation) 
                                        ? json_decode($business->countries_of_operation, true) 
                                        : [])
                            );
                        @endphp

                        <select class="form-select search_select" name="countries_of_operation[]" multiple required>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ in_array($country, $savedCountries) ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label> Short Introduction</label>
                        <textarea name="short_introduction" class="form-control" rows="2">{{ old('short_introduction', $business->short_introduction) }}</textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Business Address</label>
                        <textarea name="business_address" class="form-control" rows="2">{{ old('business_address', $business->business_address) }}</textarea>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $business->email) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Website</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website', $business->website) }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="card-header mt-2">Social Media: </div>
                    {{-- Social links --}}
                    <div class="col-md-6 mt-2 form-group">
                        <label>Facebook</label>
                        <input type="string" name="facebook" class="form-control" value="{{ old('facebook', $business->facebook) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Instagram</label>
                        <input type="string" name="instagram" class="form-control" value="{{ old('instagram', $business->instagram) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>LinkedIn</label>
                        <input type="string" name="linkedin" class="form-control" value="{{ old('linkedin', $business->linkedin) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>YouTube</label>
                        <input type="string" name="youtube" class="form-control" value="{{ old('youtube', $business->youtube) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Online Store</label>
                        <input type="string" name="online_store" class="form-control" value="{{ old('online_store', $business->online_store) }}">
                    </div>
                </div>
            </div>
    
            <div class="card-header">Founder & Contact: </div>
            <div class="card-body">
                <div id="founders-container">
                    {{-- @php
                        $founders = json_decode($business->founders, true) ?? [];
                    @endphp --}}
                    @php
                        // Ensure $founders is always an array
                        $founders = old(
                            'founders',
                            is_array($business->founders) 
                                ? $business->founders 
                                : (is_string($business->founders) 
                                    ? json_decode($business->founders, true) 
                                    : [])
                        );
                    @endphp
                    @if(count($founders) > 0)
                        @foreach($founders as $index => $founder)
                        <div class="row founder-row mb-2">
                            <div class="col-md-3 form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="founders[{{ $index }}][name]" class="form-control" value="{{ old("founders.$index.name", $founder['name'] ?? '') }}" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Designation</label>
                                <input type="text" name="founders[{{ $index }}][designation]" class="form-control" value="{{ old("founders.$index.designation", $founder['designation'] ?? '') }}">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="founders[{{ $index }}][whatsapp]" class="form-control" value="{{ old("founders.$index.whatsapp", $founder['whatsapp'] ?? '') }}">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>LinkedIn</label>
                                <input type="string" name="founders[{{ $index }}][linkedin]" class="form-control" value="{{ old("founders.$index.linkedin", $founder['linkedin'] ?? '') }}">
                            </div>
                            <div class="col-md-12 mt-2 text-end">
                                <button type="button" class="btn btn-danger remove-founder">Remove</button>
                            </div>
                            <hr class="my-2">
                        </div>
                        @endforeach
                    @else
                        {{-- No founders yet --}}
                        <div class="row founder-row mb-2">
                            <div class="col-md-3 form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="founders[0][name]" class="form-control" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Designation</label>
                                <input type="text" name="founders[0][designation]" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>WhatsApp</label>
                                <input type="text" name="founders[0][whatsapp]" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>LinkedIn</label>
                                <input type="url" name="founders[0][linkedin]" class="form-control">
                            </div>
                            <div class="col-md-12 mt-2 text-end">
                                <button type="button" class="btn btn-danger remove-founder">Remove</button>
                            </div>
                            <hr class="my-2">
                        </div>
                    @endif
                </div>

                <button type="button" id="add-founder" class="btn btn-primary mt-2">Add Founder</button>
            </div>
        </div>

        {{-- Step 2: Business Size, Structure, Description & Files --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">Step 2: Business Size, Structure, Description & Files</div>
            <div class="card-body">
                <div class="row">
                    {{-- Registration Status --}}
                    <div class="col-md-3 form-group">
                        <label>Registration Status</label>
                        <select name="registration_status" class="form-control">
                            @php
                                $registrationStatuses = [
                                    'registered_company' => 'Registered Company', 
                                    'sole_proprietorship' => 'Sole Proprietorship', 
                                    'partnership' => 'Partnership', 
                                    'startup_early_stage' => 'Startup (Early Stage)', 
                                    'home_based' => 'Home Based', 
                                    'not_registered_yet' => 'Not Registered Yet'
                                ];
                            @endphp
                            @foreach($registrationStatuses as $key => $label)
                                <option value="{{ $key }}" {{ old('registration_status', $business->registration_status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Employee Count --}}
                    <div class="col-md-3 form-group">
                        <label>Employee Count</label>
                        <select name="employee_count" class="form-control">
                            @php $employeeCounts = ['1-3','4-10','11-25','26-50','51+']; @endphp
                            @foreach($employeeCounts as $count)
                                <option value="{{ $count }}" {{ old('employee_count', $business->employee_count) == $count ? 'selected' : '' }}>{{ $count }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Operational Scale --}}
                    <div class="col-md-3 form-group">
                        <label>Operational Scale</label>
                        <select name="operational_scale" class="form-control">
                            @php $operationalScales = ['local','nationwide','international','online_only','hybrid']; @endphp
                            @foreach($operationalScales as $scale)
                                <option value="{{ $scale }}" {{ old('operational_scale', $business->operational_scale) == $scale ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$scale)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Annual Revenue --}}
                    <div class="col-md-3 form-group">
                        <label>Annual Revenue</label>
                        <select name="annual_revenue" class="form-control">
                            @php
                                $annualRevenues = [
                                    'under_10k'=>'Under 10k', 
                                    '10k-50k'=>'10k-50k', 
                                    '50k-200k'=>'50k-200k', 
                                    '200k-1m'=>'200k-1m', 
                                    'above_1m'=>'Above 1m'
                                ];
                            @endphp
                            @foreach($annualRevenues as $key => $label)
                                <option value="{{ $key }}" {{ old('annual_revenue', $business->annual_revenue) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Business Overview --}}
                    <div class="col-md-12 form-group mt-3">
                        <label>Business Overview</label>
                        <textarea name="business_overview" class="form-control" rows="3">{{ old('business_overview', $business->business_overview) }}</textarea>
                    </div>

                    {{-- Services --}}
                    {{-- @php
                        $serviceIds = is_array($business->services_id) 
                                        ? $business->services_id 
                                        : json_decode($business->services_id, true) ?? [];
                        // Fetch service names from DB
                        $serviceNames = \App\Models\Service::whereIn('id', $serviceIds)->pluck('name')->toArray();
                    @endphp --}}
                    @php
                        $savedServices = old('services_id', 
                            is_array($business->services_id ?? null) 
                                ? $business->services_id 
                                : json_decode($business->services_id ?? '[]', true)
                        );
                        // dd($savedServices, $business->services_id); // Uncomment to debug
                    @endphp

                    <div class="col-md-12 form-group">
                        <label class="form-label">Products / Services</label>
                        <select class="form-select search_select @error('services_id') is-invalid @enderror" 
                                multiple name="services_id[]" id="services">
                            <!-- Options will be loaded by JavaScript -->
                        </select>
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-6">
                            <div class="row">
                                {{-- Logo --}}
                                <div class="col-md-6 form-group">
                                    <label>Logo</label>
                                    <div class="mb-2">
                                        <img id="logoPreview" src="{{ $business->logo ? asset('assets/' . $business->logo) : '' }}" class="img-thumbnail" style="max-width:100px;">
                                    </div>
                                    <input type="file" name="logo" class="form-control-file" onchange="previewImage(this, 'logoPreview')">
                                </div>

                                {{-- Cover Photo --}}
                                <div class="col-md-6 form-group">
                                    <label>Cover Photo</label>
                                    <div class="mb-2">
                                        <img id="coverPreview" src="{{ $business->cover_photo ? asset('assets/' . $business->cover_photo) : '' }}" class="img-thumbnail" style="max-width:100px;">
                                    </div>
                                    <input type="file" name="cover_photo" class="form-control-file" onchange="previewImage(this, 'coverPreview')">
                                </div>
                            </div>
                            

                            {{-- Business Photos --}}
                            <div class="col-md-12 mt-3 form-group">
                                <label>Business Photos</label>
                                <div class="mb-2" id="photosPreview">
                                    @if($business->photos)
                                        @foreach(is_array($business->photos) ? $business->photos : json_decode($business->photos, true) as $photo)
                                            <img src="{{ asset('assets/' . $photo) }}" class="img-thumbnail mb-1" style="max-width:100px;">
                                        @endforeach
                                    @endif
                                </div>
                                <input type="file" name="photos[]" class="form-control-file" multiple onchange="previewMultipleImages(this, 'photosPreview')">
                            </div>
                        </div>
                        <div class="col-md-6">
                        {{-- Registration Document --}}
                        <div class="col-md-12 form-group">
                            <label>Registration Document</label>
                            <div class="mb-2">
                                @if($business->registration_document)
                                    <a href="{{ asset('assets/' . $business->registration_document) }}" target="_blank" class="btn btn-info btn-sm">View Document</a>
                                @endif
                            </div>
                            <input type="file" name="registration_document" class="form-control-file">
                        </div>

                        {{-- Business Profile --}}
                        <div class="col-md-12 form-group mt-3">
                            <label>Business Profile</label>
                            <div class="mb-2">
                                @if($business->business_profile)
                                    <a href="{{ asset('assets/' . $business->business_profile) }}" target="_blank" class="btn btn-info btn-sm">View File</a>
                                @endif
                            </div>
                            <input type="file" name="business_profile" class="form-control-file">
                        </div>

                        {{-- Product Catalogue --}}
                        <div class="col-md-12 form-group mt-3">
                            <label>Product Catalogue</label>
                            <div class="mb-2">
                                @if($business->product_catalogue)
                                    <a href="{{ asset('assets/' . $business->product_catalogue) }}" target="_blank" class="btn btn-info btn-sm">View File</a>
                                @endif
                            </div>
                            <input type="file" name="product_catalogue" class="form-control-file">
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- Step 3: Ethics & Collaboration --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">Step 3: Ethics & Collaboration</div>
            <div class="card-body">
                <div class="row">
                    <div class="row">



                        <div class="col-md-7">
                            {{-- Avoid Riba --}}
                            <div class="col-md-12 form-group">
                                <label class="form-label question-label">Avoid Interest (Riba)? *</label>
                                @php $value = old('avoid_riba', $business->avoid_riba ?? ''); @endphp
                                <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                    @foreach([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                        'partially_transitioning' => 'Partially Transitioning',
                                        'prefer_not_to_say' => 'Prefer Not to Say'
                                    ] as $key => $label)
                                        <label class="btn btn-outline-secondary {{ $value === $key ? 'active' : '' }}">
                                            <input type="radio" name="avoid_riba" value="{{ $key }}" autocomplete="off" {{ $value === $key ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Avoid Haram Products --}}
                            <div class="col-md-12 form-group mt-3">
                                <label class="form-label question-label">Avoid Haram Products? *</label>
                                @php $value = old('avoid_haram_products', $business->avoid_haram_products ?? ''); @endphp
                                <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                    @foreach([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                        'partially_compliant' => 'Partially Compliant',
                                        
                                    ] as $key => $label)
                                        <label class="btn btn-outline-secondary {{ $value === $key ? 'active' : '' }}">
                                            <input type="radio" name="avoid_haram_products" value="{{ $key }}" autocomplete="off" {{ $value === $key ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Fair Pricing --}}
                            <div class="col-md-12 form-group mt-3">
                                <label class="form-label question-label">Fair Pricing *</label>
                                @php $value = old('fair_pricing', $business->fair_pricing ?? ''); @endphp
                                <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                    @foreach([
                                        'yes' => 'Yes',
                                        'mostly' => 'Mostly',
                                        'needs_improvement' => 'Needs Improvement'
                                    ] as $key => $label)
                                        <label class="btn btn-outline-secondary {{ $value === $key ? 'active' : '' }}">
                                            <input type="radio" name="fair_pricing" value="{{ $key }}" autocomplete="off" {{ $value === $key ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Open for Guidance --}}
                            <div class="col-md-12 form-group mt-3">
                                <label class="form-label question-label">Open for Guidance *</label>
                                @php $value = old('open_for_guidance', $business->open_for_guidance ?? ''); @endphp
                                <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                    @foreach([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                        'maybe' => 'Maybe'
                                    ] as $key => $label)
                                        <label class="btn btn-outline-secondary {{ $value === $key ? 'active' : '' }}">
                                            <input type="radio" name="open_for_guidance" value="{{ $key }}" autocomplete="off" {{ $value === $key ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Collaboration Open --}}
                            <div class="col-md-12 form-group mt-3">
                                <label class="form-label question-label">Collaboration Open *</label>
                                @php $value = old('collaboration_open', $business->collaboration_open ?? ''); @endphp
                                <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                    @foreach([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                        'maybe' => 'Maybe'
                                    ] as $key => $label)
                                        <label class="btn btn-outline-secondary {{ $value === $key ? 'active' : '' }}">
                                            <input type="radio" name="collaboration_open" value="{{ $key }}" autocomplete="off" {{ $value === $key ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 ml-4">
                            <p>Collaboration Interest: </p>
                            @php
                                $savedCollaborationTypes = old('collaboration_types', 
                                    is_array($business->collaboration_types ?? null) 
                                        ? $business->collaboration_types 
                                        : json_decode($business->collaboration_types ?? '[]', true)
                                );
                            @endphp

                            @foreach(['Partnerships','Investment Oportunities','Vendor Supply Chain','Marketing Promotion','Networking','Training Workshops','Community Charity Projects','Not Sure Yet'] as $type)
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        name="collaboration_types[]" 
                                        value="{{ $type }}"
                                        {{ in_array($type, $savedCollaborationTypes) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $type }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    



                    <div class="col-md-12 form-group mt-2">
                        <label>Ethical Description</label>
                        <textarea name="ethical_description" class="form-control" rows="3">{{ old('ethical_description', $business->ethical_description) }}</textarea>
                    </div>
                    

                    {{-- <div class="col-md-6 form-group">
                        <label>Collaboration Types</label>
                        <textarea name="collaboration_types" class="form-control" rows="3">{{ old('collaboration_types', is_array($business->collaboration_types) ? implode(', ', $business->collaboration_types) : $business->collaboration_types) }}</textarea>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- Step 4: Consent & Approval --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">Step 4: Consent & Approval</div>
            <div class="card-body">
                <div class="row">
                    {{-- Info Accuracy --}}
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input type="checkbox" name="info_accuracy" value="1" class="form-check-input"
                                {{ old('info_accuracy', $business->info_accuracy) ? 'checked' : '' }} required>
                            <label class="form-check-label">Info Accuracy (Must be checked)</label>
                        </div>
                    </div>

                    {{-- Allow Publish --}}
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input type="checkbox" name="allow_publish" value="1" class="form-check-input"
                                {{ old('allow_publish', $business->allow_publish) ? 'checked' : '' }}>
                            <label class="form-check-label">Allow Publish (Yes/No)</label>
                        </div>
                    </div>

                    {{-- Allow Contact --}}
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input type="checkbox" name="allow_contact" value="1" class="form-check-input"
                                {{ old('allow_contact', $business->allow_contact) ? 'checked' : '' }} required>
                            <label class="form-check-label">Allow Contact (Must be checked)</label>
                        </div>
                    </div>

                    {{-- Digital Signature --}}
                    <div class="col-md-12 mt-3 form-group">
                        <label>Digital Signature (Full Name + Date)</label>
                        <input type="text" name="digital_signature" class="form-control"
                            value="{{ old('digital_signature', $business->digital_signature) }}">
                    </div>
                </div>
            </div>
        </div>


        {{-- Step 5: Status --}}
        <div class="card mb-3">
            <div class="card-header bg-info text-white">Step 5: Status - for Admin only</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ old('status', $business->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $business->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $business->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="banned" {{ old('status', $business->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5 mt-5">
            <button type="submit" class="btn btn-primary">Update Business</button>
            <a href="{{ route('gme-business-admin.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- Global Loader -->
<div id="pageLoader" class="position-fixed top-0 start-0 w-100 h-100 d-none"
     style="background: rgba(255,255,255,0.8); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <div class="fw-semibold">Please wait, Status has been updated...</div>
        </div>
    </div>
</div>


{{-- JS for dynamic founder fields --}}
    <script>
        let founderIndex = {{ count($founders) }};
        
        document.getElementById('add-founder').addEventListener('click', function() {
            const container = document.getElementById('founders-container');
            const row = document.createElement('div');
            row.classList.add('row', 'founder-row', 'mb-2');
            row.innerHTML = `
                <div class="col-md-3 form-group">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="founders[${founderIndex}][name]" class="form-control" required>
                </div>
                <div class="col-md-3 form-group">
                    <label>Designation</label>
                    <input type="text" name="founders[${founderIndex}][designation]" class="form-control">
                </div>
                <div class="col-md-3 form-group">
                    <label>WhatsApp</label>
                    <input type="text" name="founders[${founderIndex}][whatsapp]" class="form-control">
                </div>
                <div class="col-md-3 form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="founders[${founderIndex}][linkedin]" class="form-control">
                </div>
                <div class="col-md-12 mt-2 text-end">
                    <button type="button" class="btn btn-danger remove-founder">Remove</button>
                </div>
                <hr class="my-2">
            `;
            container.appendChild(row);
            founderIndex++;
        });

        // Remove founder row
        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-founder')) {
                e.target.closest('.founder-row').remove();
            }
        });
    </script>
    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, previewContainerId) {
            const container = document.getElementById(previewContainerId);
            container.innerHTML = '';
            if(input.files){
                Array.from(input.files).forEach(file => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'img-thumbnail mb-1';
                    img.style.maxWidth = '100px';
                    container.appendChild(img);
                });
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {

            let categoryId = "{{ $business->business_category_id ?? '' }}";
            let $services = $('#services');

            // Get selected services
            let selectedServices = @json(
                old(
                    'services_id',
                    is_array($business->services_id ?? null)
                        ? $business->services_id
                        : json_decode($business->services_id ?? '[]', true)
                ) ?? []
            );

            console.log('Category ID:', categoryId);
            console.log('Selected Services:', selectedServices);

            // Initial load
            if (categoryId && $services.length) {
                loadServices(categoryId, selectedServices);
            }

            // On category change
            $('#business_category').on('change', function () {
                const newCategoryId = $(this).val();

                if (newCategoryId) {
                    loadServices(newCategoryId, []);
                } else {
                    $services.empty().append('<option value="">Select category first</option>');
                }
            });

            function loadServices(catId, selected = []) {

                if (!Array.isArray(selected)) {
                    selected = [];
                }

                $.ajax({
                    url: '/get-services/' + catId,
                    type: 'GET',
                    success: function (data) {

                        $services.empty();

                        if (!Array.isArray(data) || data.length === 0) {
                            $services.append('<option value="">No services found</option>');
                            return;
                        }

                        $.each(data, function (index, service) {

                            const serviceId   = service?.id ?? null;
                            const serviceName = service?.name ?? '';

                            if (!serviceId || !serviceName) {
                                return;
                            }

                            const isSelected = selected.some(function (val) {
                                return val != null && val.toString() === serviceId.toString();
                            });

                            $services.append(`
                                <option value="${serviceId}" ${isSelected ? 'selected' : ''}>
                                    ${serviceName}
                                </option>
                            `);
                        });
                    },
                    error: function () {
                        $services.empty().append('<option value="">Error loading services</option>');
                    }
                });
            }
        });

        /* ================= LOGO PREVIEW ================= */
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];

                if (file.size > 2048 * 1024) {
                    alert('Logo file size must be less than 2MB');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('logoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        /* ================= COVER PHOTO PREVIEW ================= */
        function previewCoverPhoto(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];

                if (file.size > 5120 * 1024) {
                    alert('Cover photo file size must be less than 5MB');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('coverPhotoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

    /* ================= GALLERY ================= */
        let galleryFiles = new DataTransfer();

        function previewGallery(input) {
            const container = document.getElementById('gallery-container');
            const uploadBox = container.querySelector('.gallery-upload');
            const existingPhotos = container.querySelectorAll('.existing-photo').length;

            Array.from(input.files).forEach(file => {

                if (galleryFiles.files.length + existingPhotos >= 5) {
                    alert('Maximum 5 photos allowed');
                    return;
                }

                if (file.size > 5120 * 1024) {
                    alert('Each photo must be less than 5MB');
                    return;
                }

                galleryFiles.items.add(file);

                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'position-relative rounded new-photo';
                    div.style.cssText = 'width:10rem;height:10rem;border:1px dashed #ccc;overflow:hidden;';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-100 h-100" style="object-fit:cover;">
                        <button type="button"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0"
                            onclick="removeNewPhoto(this)">×</button>
                    `;
                    container.insertBefore(div, uploadBox);
                };
                reader.readAsDataURL(file);
            });

            input.files = galleryFiles.files;
        }

        function removeNewPhoto(btn) {
            const photos = document.querySelectorAll('.new-photo');
            const index = [...photos].indexOf(btn.parentElement);

            if (index > -1) {
                galleryFiles.items.remove(index);
            }

            btn.parentElement.remove();
            document.querySelector('input[name="photos[]"]').files = galleryFiles.files;
        }

        function removeGalleryImage(btn) {
            if (confirm('Are you sure you want to remove this image?')) {
                btn.closest('.existing-photo').remove();
            }
        }
    </script>

    <script>
        $(document).ready(function () {

            $('form').on('submit', function () {
                // Show loader
                $('#pageLoader').removeClass('d-none');

                // Disable submit button to prevent double click
                $(this).find('button[type="submit"]').prop('disabled', true);
            });

        });
    </script>
@endsection
