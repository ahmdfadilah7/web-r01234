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

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Pembelian</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                @if(Request::segment(2)=='barang')
                    <a href="{{ route('pembelian.barang.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                @else
                    <a href="{{ route('pembelian.aksesoris.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if($msg = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p>{{ $msg }}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif ($msg = Session::get('danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p>{{ $msg }}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row page-titles mx-0">
                            <div class="col-sm-12 p-md-0">
                                {!! Form::open(['method' => 'post', 'route' => ['pembelian.export']]) !!}

                                    @if(Request::segment(2)=='barang')
                                        <input type="hidden" name="kategori" value="barang">
                                    @else
                                        <input type="hidden" name="kategori" value="aksesoris">
                                    @endif

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Dari</label>
                                                <input type="date" name="dari" class="form-control">
                                                <i class="text-danger">{{ $errors->first('dari') }}</i>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Sampai</label>
                                                <input type="date" name="sampai" class="form-control">
                                                <i class="text-danger">{{ $errors->first('sampai') }}</i>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Jenis</label>
                                                <select name="jenis" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="excel">EXCEL</option>
                                                </select>
                                                <i class="text-danger">{{ $errors->first('jenis') }}</i>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <button type="submit" class="btn btn-primary mt-4">Export</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Supplier</th>
                                        @if(Request::segment(2)=='barang')
                                            <th>Nama Barang</th>
                                        @else
                                            <th>Nama Aksesoris</th>
                                        @endif
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        @if(Auth::user()->level <> 'Operator')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "ordering": 'true',
            @if (Request::segment(2)=='barang')
                ajax: {
                    url: "{{ route('pembelian.list', 'barang') }}",
                    data: function(d) {}
                },
            @else
                ajax: {
                    url: "{{ route('pembelian.list', 'aksesoris') }}",
                    data: function(d) {}
                },
            @endif
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'nama_supplier',
                    name: 'nama_supplier'
                },
                @if (Request::segment(2)=='barang')
                    {
                        data: 'nama_barang',
                        name: 'barangs.nama_barang'
                    },
                @else
                    {
                        data: 'nama_aksesoris',
                        name: 'aksesoris.nama_aksesoris'
                    },
                @endif
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                @if (Auth::user()->level <> 'Operator')
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                @endif
            ]
        });
    });
</script>

@endsection