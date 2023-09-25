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
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('penyewaan') }}">Penyewaan</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['penyewaan.store'], 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No Referensi</h4></label>
                                        <input type="text" name="no_referensi" class="form-control" value="{{ $no_referensi }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama Penyewa</h4></label>
                                        <input type="text" name="nama_penyewa" class="form-control" value="{{ old('nama_penyewa') }}">
                                        <i class="text-danger">{{ $errors->first('nama_penyewa') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No Telepon Penyewa</h4></label>
                                        <input type="number" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                                        <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Barang</h4></label>
                                        <select name="barang_id" class="form-control">
                                            <option value=" ">- Pilih -</option>
                                            @foreach($barang as $row)
                                                <option value="{{ $row->id }}">{{ $row->kode_barang.' - '.$row->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('barang_id') }}</i>
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
                                        <label for=""><h4 class="card-title">Dari Tanggal</h4></label>
                                        <input type="date" name="dari" class="form-control" value="{{ old('dari') }}">
                                        <i class="text-danger">{{ $errors->first('dari') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Sampai Tanggal</h4></label>
                                        <input type="date" name="sampai" class="form-control" value="{{ old('sampai') }}">
                                        <i class="text-danger">{{ $errors->first('sampai') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Total Harga (RP)</h4></label>
                                        <input type="number" name="total" class="form-control" value="{{ old('total') }}">
                                        <i class="text-danger">{{ $errors->first('total') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('penyewaan') }}" class="btn btn-warning">Kembali</a>
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