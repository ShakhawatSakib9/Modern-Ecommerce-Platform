@extends('backend.layouts.app')

@section('title', 'Business Intelligence Reports')
@section('page_title', 'Analytics & Reports')

@section('breadcrumb')
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Quick Stats Row -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="card shadow-sm border-0 hover-lift bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.7rem; opacity: 0.8; letter-spacing: 1px;">Total Revenue</h6>
                            <h3 class="font-weight-bold mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <div class="icon-circle bg-white-20">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card shadow-sm border-0 hover-lift bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.7rem; opacity: 0.8; letter-spacing: 1px;">Total Orders</h6>
                            <h3 class="font-weight-bold mb-0">{{ number_format($totalOrders) }}</h3>
                        </div>
                        <div class="icon-circle bg-white-20">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card shadow-sm border-0 hover-lift bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.7rem; opacity: 0.8; letter-spacing: 1px;">Avg. Order Value</h6>
                            <h3 class="font-weight-bold mb-0">${{ number_format($averageOrderValue, 2) }}</h3>
                        </div>
                        <div class="icon-circle bg-white-20">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card shadow-sm border-0 hover-lift bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.7rem; opacity: 0.8; letter-spacing: 1px;">Total Inventory</h6>
                            <h3 class="font-weight-bold mb-0">{{ number_format($totalStock) }}</h3>
                        </div>
                        <div class="icon-circle bg-white-20">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-primary font-weight-bold"><i class="fas fa-chart-area mr-2"></i>Sales Performance</h5>
                    <div class="card-tools ml-auto">
                        <form action="{{ route('admin.reports.index') }}" method="GET" id="rangeForm">
                            <select name="time_range" class="form-control form-control-sm shadow-none" onchange="this.form.submit()">
                                <option value="week" {{ $timeRange == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="month" {{ $timeRange == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ $timeRange == 'year' ? 'selected' : '' }}>This Year</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="salesPerformanceChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom">
                    <h5 class="card-title text-primary font-weight-bold"><i class="fas fa-chart-pie mr-2"></i>Category Distribution</h5>
                </div>
                <div class="card-body p-4">
                    <div id="categoryDistributionChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Top Products -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom">
                    <h5 class="card-title text-primary font-weight-bold"><i class="fas fa-star mr-2"></i>Top 5 Products</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-4">Product Name</th>
                                    <th class="text-center">Total Sold</th>
                                    <th class="text-right pr-4">Earnings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $product)
                                <tr>
                                    <td class="pl-4 font-weight-bold">{{ Str::limit($product->name, 35) }}</td>
                                    <td class="text-center"><span class="badge badge-primary-soft text-primary">{{ $product->total_sold }} units</span></td>
                                    <td class="text-right pr-4 font-weight-bold">${{ number_format($product->total_sold * $product->selling_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inventory Health -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom">
                    <h5 class="card-title text-primary font-weight-bold"><i class="fas fa-heartbeat mr-2"></i>Inventory Health</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-4">
                        <div class="col-4 border-right">
                            <h2 class="font-weight-bold text-success">{{ $totalStock }}</h2>
                            <small class="text-uppercase text-muted" style="letter-spacing: 1px;">In Stock</small>
                        </div>
                        <div class="col-4 border-right">
                            <h2 class="font-weight-bold text-warning">{{ $lowStockCount }}</h2>
                            <small class="text-uppercase text-muted" style="letter-spacing: 1px;">Low Stock</small>
                        </div>
                        <div class="col-4">
                            <h2 class="font-weight-bold text-danger">{{ $outOfStockCount }}</h2>
                            <small class="text-uppercase text-muted" style="letter-spacing: 1px;">Out of Stock</small>
                        </div>
                    </div>
                    <div id="inventoryHealthChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        height: 3rem;
        width: 3rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .bg-white-20 {
        background: rgba(255, 255, 255, 0.2);
    }

    .badge-primary-soft {
        background-color: rgba(78, 115, 223, 0.1);
        padding: 5px 12px;
        border-radius: 30px;
    }

    #salesPerformanceChart,
    #categoryDistributionChart,
    #inventoryHealthChart {
        min-height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Sales Performance Chart
        var salesOptions = {
            series: [{
                name: 'Revenue',
                type: 'area',
                data: {
                    !!json_encode($salesData['revenue']) !!
                }
            }, {
                name: 'Orders',
                type: 'line',
                data: {
                    !!json_encode($salesData['orders']) !!
                }
            }],
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: [4, 4]
            },
            colors: ['#4e73df', '#1cc88a'],
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            labels: {
                !!json_encode($salesData['labels']) !!
            },
            markers: {
                size: 4
            },
            yaxis: [{
                    title: {
                        text: 'Revenue ($)'
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: 'Orders Count'
                    }
                }
            ]
        };
        new ApexCharts(document.querySelector("#salesPerformanceChart"), salesOptions).render();

        // 2. Category Distribution Chart
        var categoryOptions = {
            series: {
                !!json_encode($categoryStats - > pluck('products_count')) !!
            },
            chart: {
                type: 'donut',
                height: 350
            },
            labels: {
                !!json_encode($categoryStats - > pluck('name')) !!
            },
            colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        new ApexCharts(document.querySelector("#categoryDistributionChart"), categoryOptions).render();

        // 3. Inventory Health Chart
        var inventoryOptions = {
            series: [{
                {
                    $totalStock
                }
            }, {
                {
                    $lowStockCount
                }
            }, {
                {
                    $outOfStockCount
                }
            }],
            chart: {
                type: 'radialBar',
                height: 350,
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px'
                        },
                        value: {
                            fontSize: '16px'
                        },
                        total: {
                            show: true,
                            label: 'Total Items',
                            formatter: function(w) {
                                return {
                                    {
                                        $totalStock
                                    }
                                }
                            }
                        }
                    }
                }
            },
            labels: ['Total Stock', 'Low Stock', 'Out of Stock'],
            colors: ['#1cc88a', '#f6c23e', '#e74a3b'],
        };
        new ApexCharts(document.querySelector("#inventoryHealthChart"), inventoryOptions).render();
    });
</script>
@endpush