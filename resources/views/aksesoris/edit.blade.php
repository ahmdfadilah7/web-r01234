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
                    <h4>Aksesoris</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('aksesoris') }}">Aksesoris</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['aksesoris.update', $aksesoris->id], 'enctype' => 'multipart/form-data']) !!}
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kode aksesoris</h4></label>
                                        <input type="text" name="kode_aksesoris_value" class="form-control" value="{{ $aksesoris->kode_aksesoris }}" readonly>
                                        <i class="text-danger">{{ $errors->first('kode_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama aksesoris</h4></label>
                                        <input type="text" name="nama_aksesoris" class="form-control" value="{{ $aksesoris->nama_aksesoris }}">
                                        <i class="text-danger">{{ $errors->first('nama_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Merk aksesoris</h4></label>
                                        <input type="text" name="merk_aksesoris" class="form-control" value="{{ $aksesoris->merk_aksesoris }}">
                                        <i class="text-danger">{{ $errors->first('merk_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kategori aksesoris</h4></label>
                                        <select name="kategori_id" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach($kategori as $row)
                                                <option value="{{ $row->id }}" @if($row->id==$aksesoris->kategori_id) {{ 'selected' }} @endif>{{ $row->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('kategori_id') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Satuan aksesoris</h4></label>
                                        <select name="satuan_id" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach($satuan as $row)
                                                <option value="{{ $row->id }}" @if($row->id==$aksesoris->satuan_id) {{ 'selected' }} @endif>{{ $row->nama_satuan.' - '.$row->keterangan }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('satuan_id') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Gambar aksesoris</h4></label>
                                        <div class="custom-file">
                                            <input type="file" name="gambar_aksesoris" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <img src="{{ url($aksesoris->gambar_aksesoris) }}" width="70">
                                        <i class="text-danger">{{ $errors->first('gambar_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Harga aksesoris (RP)</h4></label>
                                        <input type="number" name="harga_aksesoris" class="form-control" value="{{ $aksesoris->harga_aksesoris }}">
                                        <i class="text-danger">{{ $errors->first('harga_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Deskripsi aksesoris</h4></label>
                                        <textarea name="deskripsi_aksesoris" class="form-control summernote" rows="5">{{ $aksesoris->deskripsi_aksesoris }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('aksesoris') }}" class="btn btn-danger">Kembali</a>
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