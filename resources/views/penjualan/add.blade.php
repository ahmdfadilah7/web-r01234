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
                    <h4>Penjualan</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    @if(Request::segment(2)=='barang')
                        <li class="breadcrumb-item"><a href="{{ route('penjualan.barang') }}">Penjualan</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Barang</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('penjualan.aksesoris') }}">Penjualan</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Aksesoris</a></li>
                    @endif
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['penjualan.store'], 'enctype' => 'multipart/form-data']) !!}

                            @if(Request::segment(2)=='barang')
                                <input type="hidden" name="jenis" value="barang">
                            @else
                                <input type="hidden" name="jenis" value="aksesoris">
                            @endif

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No. Referensi</h4></label>
                                        <input type="text" name="no_referensi" class="form-control" value="{{ $no_referensi }}" readonly>
                                        <i class="text-danger">{{ $errors->first('no_referensi') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama Pembeli</h4></label>
                                        <input type="text" name="nama_pembeli" class="form-control" value="{{ old('nama_pembeli') }}">
                                        <i class="text-danger">{{ $errors->first('nama_pembeli') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        @if(Request::segment(2)=='barang')

                                            <label for=""><h4 class="card-title">Barang</h4></label>
                                            <select name="barang_id" id="barang" class="form-control">
                                                <option value="">- Pilih -</option>
                                                @foreach($data as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kode_barang.' - '.$row->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                            <i class="text-danger">{{ $errors->first('barang_id') }}</i>

                                        @else
                                            
                                            <label for=""><h4 class="card-title">Aksesoris</h4></label>
                                            <select name="aksesoris_id" id="aksesoris" class="form-control">
                                                <option value="">- Pilih -</option>
                                                @foreach($data as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kode_aksesoris.' - '.$row->nama_aksesoris }}</option>
                                                @endforeach
                                            </select>
                                            <i class="text-danger">{{ $errors->first('aksesoris_id') }}</i>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Harga Modal (RP)</h4></label>
                                        <input type="number" name="harga_modal" class="form-control" id="harga" readonly>
                                        <i class="text-danger">{{ $errors->first('harga_modal') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Jumlah</h4></label>
                                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}">
                                        <i class="text-danger">{{ $errors->first('jumlah') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Harga Jual (RP)</h4></label>
                                        <input type="number" name="harga" class="form-control">
                                        <i class="text-danger">{{ $errors->first('harga') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    @if(Request::segment(2)=='barang')
                                        <a href="{{ route('penjualan.barang') }}" class="btn btn-warning">Kembali</a>
                                    @else
                                        <a href="{{ route('penjualan.aksesoris') }}" class="btn btn-warning">Kembali</a>
                                    @endif
                                </div>
                            </div>
                        {!! Form::close() !!}

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
    $('#barang').on('change', function(){
        var id = $('#barang').val();
        var url = '{{ url("barang") }}/'+id;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#harga').val(data.harga_barang)
            },
            error: function() {
                $('#harga').val('');
            }
        });
    });

    $('#aksesoris').on('change', function(){
        var id = $('#aksesoris').val();
        var url = '{{ url("aksesoris") }}/'+id;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#harga').val(data.harga_aksesoris)
            },
            error: function() {
                $('#harga').val('');
            }
        });
    });
</script>

@endsection