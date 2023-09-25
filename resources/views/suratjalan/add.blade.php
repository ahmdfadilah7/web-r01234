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
                    <h4>Surat Jalan</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('suratjalan') }}">Surat Jalan</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        {!! Form::open(['method' => 'post', 'route' => ['suratjalan.store'], 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No Po</h4></label>
                                        <input type="text" name="no_po" class="form-control" value="{{ old('no_po') }}">
                                        <i class="text-danger">{{ $errors->first('no_po') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Tanggal Po</h4></label>
                                        <input type="date" name="tanggal_po" class="form-control" value="{{ old('tanggal_po') }}">
                                        <i class="text-danger">{{ $errors->first('tanggal_po') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No Surat</h4></label>
                                        <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat') }}">
                                        <i class="text-danger">{{ $errors->first('no_surat') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">Tanggal</h4></label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}">
                                        <i class="text-danger">{{ $errors->first('tanggal') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for=""><h4 class="card-title">No Mobil</h4></label>
                                        <input type="text" name="no_mobil" class="form-control" value="{{ old('no_mobil') }}">
                                        <i class="text-danger">{{ $errors->first('no_mobil') }}</i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="dynamicTable">  
                                        <tr>
                                            <th>Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>  
                                            <td>
                                                <select name="barang_id[]" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    @foreach ($barang as $row)
                                                        <option value="{{ $row->id }}">{{ $row->nama_barang }}</option>
                                                    @endforeach    
                                                </select>    
                                            </td>  
                                            <td><input type="text" name="jumlah[]" placeholder="Masukkan Jumlah" class="form-control" /></td>  
                                            <td><input type="text" name="harga[]" placeholder="Masukkan Harga" class="form-control" /></td>  
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                        </tr>  
                                    </table> 
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('suratjalan') }}" class="btn btn-warning">Kembali</a>
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
    <script type="text/javascript">
    
        var i = 0;
        
        $("#add").click(function(){
    
            ++i;
    
            $("#dynamicTable").append('<tr><td><select name="barang_id[]" class="form-control"><option value="">- Pilih -</option>@foreach($barang as $row)<option value="{{ $row->id }}">{{ $row->nama_barang }}</option>@endforeach</select></td><td><input type="text" name="jumlah[]" placeholder="Masukkan Jumlah" class="form-control" /></td><td><input type="text" name="harga[]" placeholder="Masukkan Harga" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
    
        $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
        });  
    
    </script>
@endsection