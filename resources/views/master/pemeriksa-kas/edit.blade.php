@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Edit User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">Pemeriksa-kas</a></div>
        <div class="breadcrumb-item"><a href="#">Edit Pemeriksa-kas</a></div>
    </div>
</div>
<!-- @if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif -->

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
            <div class="card-header">
                <button class="btn btn-icon btn-outline-warning" onclick="window.history.back()"><i class="fa fa-arrow-circle-left"></i> Kembali</button> 
                </div>
                <div class="card-body">
                    @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endif
                    <form action="{{route('pemeriksa-kas.update', $pemeriksakas->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- <input type="hidden" name="user_id" id="user_id"> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama">Nama Pemeriksa</label>
                                    <input class="form-control" type="text" id="nama" name="nama"
                                        value="{{$pemeriksakas->nama}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Jabatan</label>
                                    <select name="jabatan_id" id="jabatan_id" class="form-control select2">
                                        @foreach($jabatans as $jabatan)
                                            <option @if($pemeriksakas->id == $jabatan->id) selected @endif value="{{$jabatan->id}}">{{$jabatan->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create"><i
                                    class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
  
    @endsection
