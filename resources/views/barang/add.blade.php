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
                    <h4>Barang</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('barang') }}">barang</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['barang.store'], 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kode barang</h4></label>
                                        <input type="hidden" name="kode_barang" value="{{ $kode_barang }}">
                                        <input type="text" name="kode_barang_value" class="form-control" value="{{ $kode_barang }}" readonly>
                                        <i class="text-danger">{{ $errors->first('kode_barang') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama barang</h4></label>
                                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
                                        <i class="text-danger">{{ $errors->first('nama_barang') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Merk barang</h4></label>
                                        <input type="text" name="merk_barang" class="form-control" value="{{ old('merk_barang') }}">
                                        <i class="text-danger">{{ $errors->first('merk_barang') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kategori barang</h4></label>
                                        <select name="kategori_id" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach($kategori as $row)
                                                <option value="{{ $row->id }}">{{ $row->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('kategori_id') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Satuan barang</h4></label>
                                        <select name="satuan_id" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach($satuan as $row)
                                                <option value="{{ $row->id }}">{{ $row->nama_satuan.' - '.$row->keterangan }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('satuan_id') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Gambar Barang</h4></label>
                                        <div class="custom-file">
                                            <input type="file" name="gambar_barang" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <i class="text-danger">{{ $errors->first('gambar_barang') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Harga Barang (RP)</h4></label>
                                        <input type="number" name="harga_barang" class="form-control" value="{{ old('harga_barang') }}">
                                        <i class="text-danger">{{ $errors->first('harga_barang') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Deskripsi Barang</h4></label>
                                        <textarea name="deskripsi_barang" class="form-control summernote" rows="5">{{ old('deskripsi_barang') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('barang') }}" class="btn btn-danger">Kembali</a>
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