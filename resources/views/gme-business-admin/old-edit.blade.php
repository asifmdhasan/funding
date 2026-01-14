@extends('layouts.master')

@section('content')
<style>
    .main-status{
        margin-left: -2rem;
    }
    </style>
<div class="container-fluid">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gme-business-admin.update', $business->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="row">
                <div class="col-md-6">
                        <h2 class="mb-4">Edit GME Business for {{ $business->business_name }}</h2> 
                </div>
                <div class="col-md-6 form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <h2 class="mb-4">Status </h2>
                        </div>
                        <div class="col-md-4 form-group main-status">
                            <select name="status" class="form-control">
                                <option value="pending" {{ old('status', $business->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $business->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $business->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                     
                </div>
            </div>


        <div class="row">
            <!-- Step 1: Business Identity -->
            <div class="col-md-6 mb-3">
                <div class="card  text-white h-100">
                    <div class="card-header bg-success">Step 1: Business Identity</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-12 form-group">
                            <label>Business Name <span class="text-danger">*</span></label>
                            <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $business->business_name) }}" required>
                        </div>
                        
                        <div class="col-md-6  form-group">
                            <label>Year Established</label>
                            <input type="text" name="year_established" class="form-control" value="{{ old('year_established', $business->year_established) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Business Category</label>
                            <input type="text" name="business_category" class="form-control" value="{{ old('business_category', $business->business_category) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <input type="text" name="business_countries" class="form-control" value="{{ old('business_countries', $business->business_countries) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input type="text" name="business_cities" class="form-control" value="{{ old('business_cities', $business->business_cities) }}">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Tagline</label>
                            <textarea  name="tagline" class="form-control" rows="2">{{ old('tagline', $business->tagline) }} </textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Address</label>
                            <textarea name="business_address" class="form-control" rows="2">{{ old('business_address', $business->business_address) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Founder & Contact -->
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 2: Founder & Contact</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>Founder Name <span class="text-danger">*</span></label>
                            <input type="text" name="founder_name" class="form-control" value="{{ old('founder_name', $business->founder_name) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Founder Email <span class="text-danger">*</span></label>
                            <input type="email" name="founder_email" class="form-control" value="{{ old('founder_email', $business->founder_email) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>WhatsApp Number</label>
                            <input type="text" name="founder_whatsapp" class="form-control" value="{{ old('founder_whatsapp', $business->founder_whatsapp) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Website</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website', $business->website) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $business->facebook) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $business->instagram) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $business->linkedin) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>YouTube</label>
                            <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $business->youtube) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Online Store</label>
                            <input type="url" name="online_store" class="form-control" value="{{ old('online_store', $business->online_store) }}">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <!-- Step 3 & 4 -->
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 3: Business Size & Structure</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>Registration Status</label>
                            <input type="text" name="registration_status" class="form-control" value="{{ old('registration_status', $business->registration_status) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Employee Count</label>
                            <input type="text" name="employee_count" class="form-control" value="{{ old('employee_count', $business->employee_count) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Operational Scale</label>
                            <input type="text" name="operational_scale" class="form-control" value="{{ old('operational_scale', $business->operational_scale) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Annual Revenue</label>
                            <input type="text" name="annual_revenue" class="form-control" value="{{ old('annual_revenue', $business->annual_revenue) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Registration Document</label>
                            @if($business->registration_document)
                                <div class="mb-2 d-flex gap-2 flex-wrap">
                                    <img src="{{ asset('assets/' . $business->registration_document) }}" alt="registration_document"style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="registration_document" class="form-control-file">
                        </div>
                        {{-- <div class="col-md-6 form-group">
                            <label>Registration Document</label>
                            <input type="file" name="registration_document" class="form-control" value="{{ old('registration_document', $business->registration_document) }}">
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 4: Business Description</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>Logo</label>
                            @if($business->logo)
                                <div class="mb-2 d-flex gap-2 flex-wrap">
                                    <img src="{{ asset('assets/' . $business->logo) }}" alt="Logo"style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control-file">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Business Photos (Max 5)</label>
                            @if($business->photos && count($business->photos) > 0)
                                <div class="mb-2 d-flex gap-2 flex-wrap">
                                    <img src="{{ asset('assets/' . $business->photos[0]) }}" alt="Business Photo" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="photos[]" class="form-control-file" multiple>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Business Overview</label>
                            <textarea name="business_overview" class="form-control" rows="4">{{ old('business_overview', $business->business_overview) }}</textarea>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Step 5 & 6 -->
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 5: Islamic Ethical Alignment</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>Avoid Riba</label>
                            <select name="avoid_riba" class="form-control">
                                <option value="">Select</option>
                                <option value="yes" {{ old('avoid_riba', $business->avoid_riba) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('avoid_riba', $business->avoid_riba) == 'no' ? 'selected' : '' }}>No</option>
                                <option value="partial" {{ old('avoid_riba', $business->avoid_riba) == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Avoid Haram Products</label>
                            <select name="avoid_haram_products" class="form-control">
                                <option value="">Select</option>
                                <option value="yes" {{ old('avoid_haram_products', $business->avoid_haram_products) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('avoid_haram_products', $business->avoid_haram_products) == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Fair Pricing</label>
                            <select name="fair_pricing" class="form-control">
                                <option value="">Select</option>
                                <option value="yes" {{ old('fair_pricing', $business->fair_pricing) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('fair_pricing', $business->fair_pricing) == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Open for Guidance</label>
                            <select name="open_for_guidance" class="form-control">
                                <option value="">Select</option>
                                <option value="yes" {{ old('open_for_guidance', $business->open_for_guidance) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('open_for_guidance', $business->open_for_guidance) == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Ethical Description</label>
                            <textarea name="ethical_description" class="form-control" rows="3">{{ old('ethical_description', $business->ethical_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 6: Collaboration</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>Open for Collaboration</label>
                            <select name="collaboration_open" class="form-control">
                                <option value="">Select</option>
                                <option value="yes" {{ old('collaboration_open', $business->collaboration_open) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('collaboration_open', $business->collaboration_open) == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Collaboration Types (JSON)</label>
                            <textarea name="collaboration_types" class="form-control" rows="3">{{ old('collaboration_types', json_encode($business->collaboration_types)) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Step 7: Consent & Status -->
            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Step 7: Consent & Status</div>
                    <div class="row card-body text-dark">
                        <div class="col-md-6 form-group">
                            <label>
                                <input type="checkbox" name="info_accuracy" value="1" {{ old('info_accuracy', $business->info_accuracy) ? 'checked' : '' }}>
                                Info Accuracy
                            </label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>
                                <input type="checkbox" name="allow_publish" value="1" {{ old('allow_publish', $business->allow_publish) ? 'checked' : '' }}>
                                Allow Publish
                            </label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>
                                <input type="checkbox" name="allow_contact" value="1" {{ old('allow_contact', $business->allow_contact) ? 'checked' : '' }}>
                                Allow Contact
                            </label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Digital Signature</label>
                            <input type="text" name="digital_signature" class="form-control" value="{{ old('digital_signature', $business->digital_signature) }}">
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card text-white h-100">
                    <div class="card-header bg-success">Contact Person (Optional)</div>
                        <div class="row card-body text-dark">
                      
                        {{-- <h6 class=""style="padding-top: 2rem;">Contact Person (Optional)</h6> --}}
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="contact_person_name" class="form-control" value="{{ old('contact_person_name', $business->contact_person_name) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <input type="text" name="contact_person_role" class="form-control" value="{{ old('contact_person_role', $business->contact_person_role) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="contact_person_email" class="form-control" value="{{ old('contact_person_email', $business->contact_person_email) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone</label>
                            <input type="text" name="contact_person_phone" class="form-control" value="{{ old('contact_person_phone', $business->contact_person_phone) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Business</button>
            <a href="{{ route('gme-business-admin.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection
