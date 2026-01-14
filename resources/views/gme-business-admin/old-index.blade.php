@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">GME Businesses</h3>
                </div>
                <div class="card-body">
                    <table id="businessesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Business Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Founder</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS/JS -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css"> --}}
{{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script> --}}

<script>
$(document).ready(function() {
    let assetBase = "{{ asset('assets') }}";
    $('#businessesTable').DataTable({
        processing: true,
        serverSide: false, // Using client-side since we send all data
        ajax: {
            url: "{{ route('gme-business-admin.index') }}",
            type: "GET",
            dataSrc: 'businesses'
        },
        columns: [
            { data: 'id', width: '50px' },
            
            { 
                data: 'business_name',
                render: function(data, type, row) {
                    let html =   data ;
                    return html;
                }
            },
            { 
                data: 'business_category',
                render: function(data) {
                    return data ? '<span class="info">' + data + '</span>' : '-';
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    let location = [];
                    if (row.business_cities) location.push(row.business_cities);
                    if (row.business_countries) location.push(row.business_countries);
                    return location.length ? location.join(', ') : '-';
                }
            },
            { data: 'founder_name' },
            { 
                data: 'status',
                render: function(data) {
                    let badgeClass = 'badge-warning';
                    if (data === 'approved') badgeClass = 'badge-success';
                    if (data === 'rejected') badgeClass = 'badge-danger';
                    return '<span class=" ' + badgeClass + '">' + data.toUpperCase() + '</span>';
                }
            },
            { 
                data: 'created_at',
                render: function(data) {
                    return new Date(data).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }
            },
            {
                data: 'logo',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + assetBase + '/' + data + '" alt="Logo" class="img-thumbnail" style="width:50px; height:50px; object-fit:cover;">';
                    }
                    return '<div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:20px;">' +
                        (row.business_name ? row.business_name.charAt(0).toUpperCase() : '?') +
                        '</div>';
                }
            },
            { 
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<a href="{{ url("gme-business-admin") }}/' + row.id + '/edit" class="btn btn-sm btn-primary">' +
                           '<i class="fas fa-edit"></i> Edit</a>';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
            emptyTable: 'No businesses found',
            zeroRecords: 'No matching businesses found'
        }
    });
});
</script>
@endsection
