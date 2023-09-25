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
                <ol class="breadcrumb">
                    @if(Request::segment(2)=='barang')
                        <li class="breadcrumb-item"><a href="{{ route('pembelian.barang') }}">Pembelian</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Barang</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('pembelian.aksesoris') }}">Pembelian</a></li>
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
                        
                        {!! Form::open(['method' => 'post', 'route' => ['pembelian.store'], 'enctype' => 'multipart/form-data']) !!}

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
                                        <label for=""><h4 class="card-title">Nama Supplier</h4></label>
                                        <input type="text" name="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}">
                                        <i class="text-danger">{{ $errors->first('nama_supplier') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        @if(Request::segment(2)=='barang')

                                            <label for=""><h4 class="card-title">Barang</h4></label>
                                            <select name="barang_id" class="form-control">
                                                <option value="">- Pilih -</option>
                                                @foreach($data as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kode_barang.' - '.$row->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                            <i class="text-danger">{{ $errors->first('barang_id') }}</i>

                                        @else
                                            
                                            <label for=""><h4 class="card-title">Aksesoris</h4></label>
                                            <select name="aksesoris_id" class="form-control">
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
                                        <label for=""><h4 class="card-title">Harga (RP)</h4></label>
                                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
                                        <i class="text-danger">{{ $errors->first('harga') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Jumlah</h4></label>
                                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}">
                                        <i class="text-danger">{{ $errors->first('jumlah') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    @if(Request::segment(2)=='barang')
                                        <a href="{{ route('pembelian.barang') }}" class="btn btn-warning">Kembali</a>
                                    @else
                                        <a href="{{ route('pembelian.aksesoris') }}" class="btn btn-warning">Kembali</a>
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