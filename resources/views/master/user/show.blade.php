@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Master User Akun</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data User Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus-circle"></i> Tambah User
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table" id="tabel-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username : {{$users->name}}</th>
                                    <th>Name</th>
                                    <th>Akun Bank</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users->akunBank as $i => $akun)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$users->username}}</td>
                                    <td>{{$users->name}}</td>
                                    <td>{{$akun->akun}}</td>
                                    <td>TODO</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


@endsection