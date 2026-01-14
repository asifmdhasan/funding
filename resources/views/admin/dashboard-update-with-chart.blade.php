@extends('layouts.master')

@section('content')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">{{ __('layouts.dashboard') }}</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.low_part_variants') }}</span>
                <p class="text-2xl font-bold">{{ $lowVariantStockCount }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <!-- Left side: icon -->
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-vault text-white"></i>
            </div>
            <!-- Right side: title on top, count below -->
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.molds') }}</span>
                <p class="text-2xl font-bold">{{ $molds }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_variants') }}</span>
                <p class="text-2xl font-bold">{{ $totalVariants }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <!-- Left side: icon -->
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-user text-white"></i>
            </div>
            <!-- Right side: title on top, count below -->
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.users') }}</span>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_variant_stock') }}</span>
                <p class="text-2xl font-bold">{{ $totalVariantStockCount }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_stock_in') }}</span>
                <p class="text-2xl font-bold">{{ $totalStockIn }}</p>
            </div>
        </div>


        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_stock_out') }}</span>
                <p class="text-2xl font-bold">{{ $totalStockOut }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-warehouse text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.warehouse') }}</span>
                <p class="text-2xl font-bold">{{ $totalWarehouses }}</p>
            </div>
        </div>

    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Low Variant Stock Distribution -->
        <div class="bg-white shadow rounded-xl p-6">
            
            <h2 class="text-lg font-bold mb-4">{{ __('layouts.low_variant_parts') }} </h2>
            <div style="width: 450px; margin: 0 auto;">
            <canvas id="lowVariantStockChart"></canvas>
            </div>
        </div>
        <!--Top Variant Stock Distribution -->
        <div class="bg-white shadow rounded-xl p-6">
            
            <h2 class="text-lg font-bold mb-4">{{ __('layouts.top_variant_parts') }} </h2>
            <div style="width: 450px; margin: 0 auto;">
            <canvas id="variantStockChart"></canvas>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">{{ __('layouts.stock_entries') }}</h2>
                <select id="stockEntryFilter" class="border rounded p-1">
                    <option value="week">{{ __('layouts.this_week') }}</option>
                    <option value="month" selected>{{ __('layouts.this_month') }}</option>
                    <option value="year">{{ __('layouts.this_year') }}</option>
                </select>
            </div>
            <canvas id="stockEntryChart"></canvas>
        </div>

        <!-- Stock out -->
        <div class="bg-white shadow rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold mb-4">{{ __('layouts.stock_out') }}</h2>
                <select id="stockOutFilter" class="border rounded p-1">
                    <option value="week">{{ __('layouts.this_week') }}</option>
                    <option value="month" selected>{{ __('layouts.this_month') }}</option>
                    <option value="year">{{ __('layouts.this_year') }}</option>
                </select>
            </div>
            <canvas id="stockOutChart"></canvas>
        </div>

        <!-- Stock In vs Out -->
        <div class="bg-white shadow rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold mb-4">{{ __('layouts.stock_in_vs_stock_out') }} </h2>
                <select id="stockInOutFilter" class="border rounded p-1">
                    <option value="week">{{ __('layouts.this_week') }}</option>
                    <option value="month" selected>{{ __('layouts.this_month') }}</option>
                    <option value="year">{{ __('layouts.this_year') }}</option>
                </select>
            </div>
            <canvas id="stockInOutChart"></canvas>
        </div>

        <!-- Purchases vs Requisitions -->
        <div class="bg-white shadow rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold mb-4">{{ __('layouts.purchases_vs_requisitions') }}</h2>
                <select id="purchaseRiquisitionFilter" class="border rounded p-1">
                    <option value="week">{{ __('layouts.this_week') }}</option>
                    <option value="month" selected>{{ __('layouts.this_month') }}</option>
                    <option value="year">{{ __('layouts.this_year') }}</option>
                </select>
            </div>
            <canvas id="purchasesRequisitionsChart"></canvas>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Low Stock Distribution
        const lowVariantStock = @json($lowVariantStock);
        new Chart(document.getElementById('lowVariantStockChart'), {
            type: 'pie',
            data: {
                labels: lowVariantStock.map(v =>
                v.part_name ? `${v.part_name} - ${v.label} (${v.stock})` : v.label
                ), //  Each item is its own string
                datasets: [{
                data: lowVariantStock.map(v => v.total),
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',  //  put legend on the left
                        align: 'start',    //  align legend items from the top
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // simple label formatting
                            return `${context.label}: ${context.raw} variants`;
                        }
                    }
                },
                layout: {
                    padding: {
                    top: 5,   // adjust this if you need more spacing
                    left: 20
                    }
                }
            }
        });

        // Top Stock Distribution
        const variantStock = @json($variantStock);
        new Chart(document.getElementById('variantStockChart'), {
            type: 'pie',
            data: {
                labels: variantStock.map(v =>
                v.part_name ? `${v.part_name} - ${v.label} (${v.stock})` : v.label
                ), //  Each item is its own string
                datasets: [{
                data: variantStock.map(v => v.total),
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',  //  put legend on the left
                        align: 'start',    //  align legend items from the top
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // simple label formatting
                            return `${context.label}: ${context.raw} variants`;
                        }
                    }
                },
                layout: {
                    padding: {
                    top: 5,   // adjust this if you need more spacing
                    left: 20
                    }
                }
            }
        });


        let stockEntryChart, stockOutChart;

        function initCharts() {
            const ctxEntry = document.getElementById('stockEntryChart').getContext('2d');
            stockEntryChart = new Chart(ctxEntry, {
                type: 'bar',
                data: { labels: [], datasets: [
                    { label: '{{ __('layouts.direct_entry') }}', data: [], backgroundColor: 'rgba(59,130,246,0.7)' },
                    { label: '{{ __('layouts.qc_passed') }}',  data: [], backgroundColor: 'rgba(34,197,94,0.7)' },
                    { label: '{{ __('layouts.transfers') }}',  data: [], backgroundColor: 'rgba(50,189,234,0.7)' }
                ]},
                options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } } }
            });


            const ctxOut = document.getElementById('stockOutChart').getContext('2d');
            stockOutChart = new Chart(ctxOut, {
                type: 'bar',
                data: { labels: [], datasets: [
                    { label: '{{ __('layouts.requisitions') }}', data: [], backgroundColor: 'rgba(239,68,68,0.7)', barPercentage: 0.9, categoryPercentage: 0.6, },
                    { label: '{{ __('layouts.transfers') }}', data: [], backgroundColor: 'rgba(245, 158, 11, 0.7)', barPercentage: 0.9, categoryPercentage: 0.6, }
                ]},
                options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } } }
            });     

            const ctxInOut = document.getElementById('stockInOutChart').getContext('2d');
            stockInOutChart = new Chart(ctxInOut, {
                type: 'line',
                data: { 
                    labels: [], 
                    datasets: [
                        { 
                            label:  '{{ __('layouts.stock_in') }}',
                            data: [], 
                            // backgroundColor: 'rgba(34,197,94,0.7)' ,


                            borderColor: "#4ade80",
                            backgroundColor: "rgba(74,222,128,0.2)",
                            // data: chartData.weekly.purchases,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: "#fff",
                            pointBorderColor: "#4ade80",
                            pointBorderWidth: 2,


                        },
                        { 
                            label: '{{ __('layouts.stock_out') }}',
                            data: [], 
                            // backgroundColor: 'rgba(239,68,68,0.7)',
                            borderColor: 'rgba(239,68,68,0.7)',
                            backgroundColor: 'rgba(239,68,68,0.2)',//"rgba(96,165,250,0.2)",
                            // data: chartData.weekly.requisitions,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: "#fff",
                            pointBorderColor: 'rgba(239,68,68,1)',
                            pointBorderWidth: 2
                        
                        }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } } }
            }); 


            const ctxPurchaseRequisition = document.getElementById('purchasesRequisitionsChart').getContext('2d');
            purchasesRequisitionsChart = new Chart(ctxPurchaseRequisition, {
                type: 'line',
                data: { 
                    labels: [], 
                    datasets: [
                        { 
                            label:  '{{ __('layouts.purchases') }}',
                            data: [], 
                            // backgroundColor: 'rgba(34,197,94,0.7)' ,


                            borderColor: "#4ade80",
                            backgroundColor: "rgba(74,222,128,0.2)",
                            // data: chartData.weekly.purchases,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: "#fff",
                            pointBorderColor: "#4ade80",
                            pointBorderWidth: 2,


                        },
                        { 
                            label: '{{ __('layouts.requisitions') }}',
                            data: [], 
                            // backgroundColor: 'rgba(239,68,68,0.7)',
                            borderColor: 'rgba(239,68,68,0.7)',
                            backgroundColor: 'rgba(239,68,68,0.2)',//"rgba(96,165,250,0.2)",
                            // data: chartData.weekly.requisitions,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: "#fff",
                            pointBorderColor: 'rgba(239,68,68,1)',
                            pointBorderWidth: 2
                        
                        }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } } }
            }); 




            
        }

        function loadStockEntryChart(filter = 'month') {
            fetch(`/stock-entry-chart?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    stockEntryChart.data.labels = data.labels;
                    stockEntryChart.data.datasets[0].data = data.direct;
                    stockEntryChart.data.datasets[1].data = data.qc_passed;
                    stockEntryChart.data.datasets[2].data = data.transfer;
                    stockEntryChart.update();
                });
        }

        function loadStockOutChart(filter = 'month') {
            fetch(`/stock-out-chart?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    stockOutChart.data.labels = data.labels;
                    stockOutChart.data.datasets[0].data = data.requisition;
                    stockOutChart.data.datasets[1].data = data.transfer;
                    stockOutChart.update();
                });
        }

        function loadStockInOutChart(filter = 'month') {
            fetch(`/stock-in-out-chart?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    stockInOutChart.data.labels = data.labels;
                    stockInOutChart.data.datasets[0].data = data.stock_in;
                    stockInOutChart.data.datasets[1].data = data.stock_out;
                    stockInOutChart.update();
                });
        }

        function loadPurchaseRequisition(filter = 'month') {
            fetch(`/purchase-and-requisition-chart?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    purchasesRequisitionsChart.data.labels = data.labels;
                    purchasesRequisitionsChart.data.datasets[0].data = data.purchases;
                    purchasesRequisitionsChart.data.datasets[1].data = data.requisitions;
                    purchasesRequisitionsChart.update();
                });
        }

        document.addEventListener("DOMContentLoaded", () => {
            initCharts();

            // Initial load
            loadStockEntryChart('month');
            loadStockOutChart('month');
            loadStockInOutChart('month');
            loadPurchaseRequisition('month');
            // loadLowVariantChart('month');

            // Dropdown listeners
            document.getElementById('stockEntryFilter').addEventListener('change', function() {
                loadStockEntryChart(this.value);
            });
            document.getElementById('stockOutFilter').addEventListener('change', function() {
                loadStockOutChart(this.value);
            });
            document.getElementById('stockInOutFilter').addEventListener('change', function() {
                loadStockInOutChart(this.value);
            });
            document.getElementById('purchaseRiquisitionFilter').addEventListener('change', function() {
                loadPurchaseRequisition(this.value);
            });
        });

    </script>
@endpush

