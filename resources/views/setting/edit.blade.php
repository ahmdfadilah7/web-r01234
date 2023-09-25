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
                    <h4>Setting Website</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('setting') }}">Setting Website</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['setting.update', $settings->id], 'enctype' => 'multipart/form-data']) !!}
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama Website</h4></label>
                                        <input type="text" name="nama_website" class="form-control" value="{{ $settings->nama_website }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama Toko</h4></label>
                                        <input type="text" name="nama_toko" class="form-control" value="{{ $settings->nama_toko }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Email</h4></label>
                                        <input type="text" name="email" class="form-control" value="{{ $settings->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No HP</h4></label>
                                        <input type="number" name="no_hp" class="form-control" value="{{ $settings->no_hp }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Logo</h4></label>
                                        <div class="custom-file">
                                            <input type="file" name="logo" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <img src="{{ url($settings->logo) }}" width="70">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Favicon</h4></label>
                                        <div class="custom-file">
                                            <input type="file" name="favicon" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <img src="{{ url($settings->favicon) }}" width="70">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Alamat</h4></label>
                                        <textarea name="alamat" class="form-control" rows="5">{{ $settings->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
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