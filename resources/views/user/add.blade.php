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
                    <h4>User Management</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">User Management</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['user.store'], 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Nama</h4></label>
                                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                                        <i class="text-danger">{{ $errors->first('nama') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Email</h4></label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                        <i class="text-danger">{{ $errors->first('email') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Username</h4></label>
                                        <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                                        <i class="text-danger">{{ $errors->first('username') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Password</h4></label>
                                        <input type="password" name="password" class="form-control">
                                        <i class="text-danger">{{ $errors->first('password') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Level</h4></label>
                                        <select name="level" class="form-control">
                                            <option value="">- Pilih -</option>
                                            @foreach($level as $row)
                                                <option value="{{ $row }}">{{ $row }}</option>
                                            @endforeach
                                        </select>
                                        <i class="text-danger">{{ $errors->first('level') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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