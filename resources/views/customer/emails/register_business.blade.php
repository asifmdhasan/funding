<h2>Business Registration Successful</h2>

{{-- <p>Dear {{ $business->customer->name }} ?? {{ $business->email }},</p> --}}
<p>Dear {{ $business->customer->name ?? $business->email }},</p>


<p>Your business has been successfully submitted and is currently under review.</p>

<p>Status: <strong>{{ ucfirst($business->status) }}</strong></p>

<p>Thank you.</p>
