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
                    <h4>Penyewaan</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('penyewaan.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
                                {!! Form::open(['method' => 'post', 'route' => ['penyewaan.export']]) !!}
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
                                                <label for="">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value=" ">- Pilih -</option>
                                                    <option value="0">Belum Diambil</option>
                                                    <option value="1">Sudah Diambil</option>
                                                    <option value="2">Selesai</option>
                                                    <option value="3">Dibatalkan</option>
                                                </select>
                                                <i class="text-danger">{{ $errors->first('status') }}</i>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Jenis</label>
                                                <select name="jenis" class="form-control">
                                                    <option value=" ">- Pilih -</option>
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
                                        <th>Nama Penyewa</th>
                                        <th>No Telepon</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Dari</th>
                                        <th>Sampai</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th width="5%">Aksi</th>
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
            ajax: {
                url: "{{ route('penyewaan.list') }}",
                data: function(d) {}
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'nama_penyewa',
                    name: 'nama_penyewa'
                },
                {
                    data: 'no_telp',
                    name: 'no_telp'
                },
                {
                    data: 'nama_barang',
                    name: 'barangs.nama_barang'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'dari',
                    name: 'dari'
                },
                {
                    data: 'sampai',
                    name: 'sampai'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

@endsection