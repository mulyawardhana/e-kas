@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Edit Kasbon</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">Kasbon</a></div>
        <div class="breadcrumb-item"><a href="#">Edit Kasbon</a></div>
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
                    <form action="{{route('kasbon.update',$kasbons->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                          
                                <div class="form-group">
                                    <label for="">Akun Bank</label>
                                    <select name="akun_bank_id" id="akun_bank_id" class="form-control select2">
                                        @foreach($akuns as $akun)
                                        <option @if($kasbons->akun_bank_id == $akun->id)selected @endif value="{{$akun->id}}">{{$akun->akun}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal kasbon</label>
                                    <input class="form-control" type="date" id="tanggal_pengajuan"
                                        name="tanggal_pengajuan" value="{{$kasbons->tanggal_pengajuan}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input class="form-control" type="text" id="nama" name="nama" value="{{$kasbons->nama}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="">Keperluan</label>
                                    <textarea class="form-control" type="text" id="keterangan"
                                        name="keterangan">{{$kasbons->keterangan}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Nominal Kasbon</label>
                                    <input class="form-control" type="text" id="nominal" name="nominal" value="{{$kasbons->nominal}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Attachemnt* </label>
                                    <input class="form-control" type="file" id="file" name="file">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    @endsection
