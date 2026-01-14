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
                                <th>SL</th>
                                <th>Logo</th>
                                <th>Business Name</th>
                                <th>Category</th>
                                <th>Countries</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {

    $('#businessesTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('gme-business-admin.index') }}",
            type: "GET",
            dataSrc: 'businesses'
        },
        columns: [

            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },

            {
                data: 'logo',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (data) {
                        return `
                            <img src="{{ asset('assets') }}/${data}"
                                class="img-thumbnail"
                                style="width:50px;height:50px;object-fit:cover;">
                        `;
                    }

                    return `
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="width:50px;height:50px;">
                            ${row.business_name ? row.business_name.charAt(0).toUpperCase() : '?'}
                        </div>
                    `;
                }
            },

            {
                data: 'business_name',
                render: function (data) {
                    return data ?? '-';
                }
            },

            {
                data: 'category',
                render: function (data, type, row) {
                    return row.category?.name ?? '-';
                }
            },

            {
                data: 'countries_of_operation',
                render: function (data) {
                    if (!data) return '-';

                    // If already array
                    if (Array.isArray(data)) {
                        return data.join(', ');
                    }

                    // If JSON string
                    try {
                        let parsed = JSON.parse(data);
                        return Array.isArray(parsed) ? parsed.join(', ') : '-';
                    } catch (e) {
                        return '-';
                    }
                }
            },

            {
                data: 'status',
                render: function (data) {

                    let cls = 'bg-secondary';

                    if (data === 'approved') cls = 'bg-success';
                    else if (data === 'pending') cls = 'bg-info';
                    else if (data === 'draft') cls = 'bg-warning';
                    else if (data === 'rejected') cls = 'bg-danger';

                    return `<span class="badge ${cls}">${data.toUpperCase()}</span>`;
                }
            },

            {
                data: 'created_at',
                render: function (data) {
                    return new Date(data).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }
            },

            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        

                        <a href="{{ url('gme-business-admin') }}/${row.id}/edit" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    `;
                }
            }

        ],
        // order: [[0, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            emptyTable: "No businesses found",
            zeroRecords: "No matching records"
        }
    });

});
</script>
{{-- <a href="{{ url('gme-business-admin') }}/${row.id}" 
                           class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a> --}}
@endsection
