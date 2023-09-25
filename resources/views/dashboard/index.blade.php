@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-layout-grid2 text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Barang</div>
                            <div class="stat-digit">{{ $barang_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-layout-grid2 text-primary border-primary"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Aksesoris</div>
                            <div class="stat-digit">{{ $aksesoris_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-money text-warning border-warning"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Pembelian</div>
                            <div class="stat-digit">{{ $pembelian_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-money text-danger border-danger"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Penjualan</div>
                            <div class="stat-digit">{{ $penjualan_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-money text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Penyewaan</div>
                            <div class="stat-digit">{{ $penyewaan_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chart</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-8">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        

    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@endsection

@section('script')

    <script>
        // Morris bar chart
        Morris.Bar({
            element: 'morris-bar-chart',
            data: [{
                y: 'Total',
                a: '{{ $pembelian_count }}',
                b: '{{ $penjualan_count }}',
                c: '{{ $penyewaan_count }}'
            }],
            xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            labels: ['Pembelian', 'Penjualan', 'Penyewaan'],
            barColors: ['#343957', '#5873FE'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
    </script>

@endsection