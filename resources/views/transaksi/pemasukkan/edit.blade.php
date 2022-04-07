@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Edit Pemasukkan Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.create')}}">Create-Pemakaian-kas</a></div>
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
                    <form action="{{route('pemasukkan-kas.update',$pemasukkan->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                                <div class="form-group ">
                                    <label for="staticEmail">Akun Bank <span class="text-danger">*</span></label>
                                    <select name="akun_bank_id" id="" class="form-control select2">
                                        <option value="">-- Pilih Akun Bank --</option>
                                        @foreach($akunBanks as $a)
                                        <option @if($pemasukkan->akun_bank_id == $a->id) selected @endif value="{{$a->id}}">{{$a->akun}}</option>
                                        @endforeach
                                    </select>
                                    @error('akun_bank_id')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                     
                                <div class="form-group ">
                                <label for="tanggal_dikeluarkan">Tanggal Pengisian<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_dikeluarkan" name="tanggal_dikeluarkan" value="{{$pemasukkan->tanggal_dikeluarkan}}"
                                      >
                                    @error('tanggal_dikeluarkan')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                        
                                <div class="form-group ">
                                    <label for="nominal">Nominal<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nominal" name="nominal"  value="{{$pemasukkan->nominal}}"
                                       >
                                    @error('nominal')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-block" id="saveBtn" value="create">Save
                                changes</button>
                        </div>
                    </form>
          

            </div>
        </div>

    </div>

</div>

@endsection
