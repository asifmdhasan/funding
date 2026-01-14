<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('layouts.siteTitle') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/tooltips.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/choices.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/site.css') }}" rel="stylesheet" />
</head>

<body class="bg-light">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content" style="margin-left:260px; min-height:100vh;">
        
        <!-- Navbar -->
        @include('layouts.navbar')

        <div class="container-fluid py-4">
            @yield('content')
        </div>

        <!-- Footer -->
        {{-- @include('layouts.footer') --}}
        
    </main>

    <!-- Core JS -->

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Choices.js -->
    <script src="{{ asset('assets/js/choices.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

    <!-- Flatpickr -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

    <!-- Custom -->
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/modal.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('assets/js/accordion.js') }}"></script>

    <!-- Global Select2 -->
    <script>
        $(document).ready(function() {
            $('.search_select').select2();
        });
    </script>

    <!-- DataTable Language -->
    <script>
        window.dataTableLanguage = {
            sProcessing: "{{ __('layouts.sProcessing') }}",
            sLengthMenu: "{{ __('layouts.sLengthMenu') }}",
            sZeroRecords: "{{ __('layouts.sZeroRecords') }}",
            sInfo: "{{ __('layouts.sInfo') }}",
            sInfoEmpty: "{{ __('layouts.sInfoEmpty') }}",
            sInfoFiltered: "{{ __('layouts.sInfoFiltered') }}",
            sSearch: "{{ __('layouts.sSearch') }}",
            oPaginate: {
                sFirst: "{{ __('layouts.sFirst') }}",
                sPrevious: "{{ __('layouts.sPrevious') }}",
                sNext: "{{ __('layouts.sNext') }}",
                sLast: "{{ __('layouts.sLast') }}"
            }
        };

        $(document).ready(function() {
            $('#allDataTable').DataTable({
                "language": window.dataTableLanguage
            });
        });
    </script>

    <!-- Delete Confirmation -->
    <script>
        function confirmDelete() {
            Swal.fire({
                title: "{{ __('layouts.delete_confirm') }}",
                text: "{{ __('layouts.not_revert') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "{{ __('layouts.delete_confirm') }}",
                cancelButtonText: "{{ __('layouts.cancel_btn') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }

        function prepareDelete(el) {
            const url = el.getAttribute('href');
            document.getElementById('deleteForm').setAttribute('action', url);
            confirmDelete();
        }
    </script>

    {{-- @stack('scripts') --}}

</body>
</html>
