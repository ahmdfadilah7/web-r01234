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
                        
                        {!! Form::open(['method' => 'post', 'route' => ['aksesoris.store'], 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kode aksesoris</h4></label>
                                        <input type="hidden" name="kode_aksesoris" value="{{ $kode_aksesoris }}">
                                        <input type="text" name="kode_aksesoris_value" class="form-control" value="{{ $kode_aksesoris }}" readonly>
                                        <i class="text-danger">{{ $errors->first('kode_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama aksesoris</h4></label>
                                        <input type="text" name="nama_aksesoris" class="form-control" value="{{ old('nama_aksesoris') }}">
                                        <i class="text-danger">{{ $errors->first('nama_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Merk aksesoris</h4></label>
                                        <input type="text" name="merk_aksesoris" class="form-control" value="{{ old('merk_aksesoris') }}">
                                        <i class="text-danger">{{ $errors->first('merk_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Kategori aksesoris</h4></label>
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
                                        <label for=""><h4 class="card-title">Satuan aksesoris</h4></label>
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
                                        <label for=""><h4 class="card-title">Gambar aksesoris</h4></label>
                                        <div class="custom-file">
                                            <input type="file" name="gambar_aksesoris" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <i class="text-danger">{{ $errors->first('gambar_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Harga aksesoris (RP)</h4></label>
                                        <input type="number" name="harga_aksesoris" class="form-control" value="{{ old('harga_aksesoris') }}">
                                        <i class="text-danger">{{ $errors->first('harga_aksesoris') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Deskripsi aksesoris</h4></label>
                                        <textarea name="deskripsi_aksesoris" class="form-control summernote" rows="5">{{ old('deskripsi_aksesoris') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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