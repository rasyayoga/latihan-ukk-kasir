@extends('main')
@section('title', '| Dashboard')

@section('content')

<div class="row">
    @if(Auth::user()->role === 'employee')
    <div class="col-lg-12 p-3"> 
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4> {{-- Tetap di pinggir kiri --}}
                
                <div class="card w-100">
                    <ul class="list-group list-group-flush d-flex flex-column" style="min-height: 200px;">
                        <li class="list-group-item bg-light d-flex justify-content-center align-items-center">
                            Total Penjualan Hari Ini
                        </li>
                        <li class="list-group-item flex-grow-1 d-flex flex-column justify-content-center align-items-center" style="min-height: 100px;">
                            <b style="font-size: 2rem;">{{ $todaySalesCount }}</b>
                            <span>Data terjual hari ini:</span>
                        </li>
                        
                        <li class="list-group-item bg-light d-flex justify-content-center align-items-center">
                            Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif



    @if(Auth::user()->role === 'admin')
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Selamat Datang {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Weekly Stats</h4>
                    <h6 class="card-subtitle">Average sales</h6>
                    <div class="mt-5 pb-3 d-flex align-items-center">
                        <span class="btn btn-primary btn-circle d-flex align-items-center">
                            <i class="mdi mdi-cart-outline fs-4"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Top Sales</h5>
                            <span class="text-muted fs-6">Johnathan Doe</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">+68%</span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-warning btn-circle d-flex align-items-center">
                            <i class="mdi mdi-star-circle fs-4"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Best Seller</h5>
                            <span class="text-muted fs-6">MaterialPro Admin</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">+68%</span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-success btn-circle d-flex align-items-center">
                            <i class="mdi mdi-comment-multiple-outline text-white fs-4"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Most Commented</h5>
                            <span class="text-muted fs-6">Ample Admin</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">+68%</span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-info btn-circle d-flex align-items-center">
                            <i class="mdi mdi-diamond fs-4 text-white"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Top Budgets</h5>
                            <span class="text-muted fs-6">Sunil Joshi</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">+15%</span>
                        </div>
                    </div>

                    <div class="pt-3 d-flex align-items-center">
                        <span class="btn btn-danger btn-circle d-flex align-items-center">
                            <i class="mdi mdi-content-duplicate fs-4 text-white"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Best Designer</h5>
                            <span class="text-muted fs-6">Nirav Joshi</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">+90%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var chart = document.getElementById('salesChart')?.getContext('2d');
        if (!chart) {
            console.error("Canvas dengan id 'salesChart' tidak ditemukan!");
            return;
        }

        var labels = @json($labels); 
        var salesData = @json($salesData);

        var salesChart = new Chart(chart, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endsection
