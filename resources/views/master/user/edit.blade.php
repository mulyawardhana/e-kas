@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Edit User</h1>

    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">User</a></div>
        <div class="breadcrumb-item"><a href="#">Edit User</a></div>
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
                    <button class="btn btn-icon btn-outline-warning" onclick="window.history.back()"><i
                            class="fa fa-arrow-circle-left"></i> Kembali</button>
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
                    <form action="{{route('user.update', $users->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- <input type="hidden" name="user_id" id="user_id"> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input class="form-control" type="text" id="username" name="username"
                                        value="{{$users->username}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{$users->name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jabatan</label>
                                    <select name="jabatan_id" id="jabatan_id" class="form-control select2">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach($jabatans as $jabatan)
                                        <option @if($users->jabatan_id == $jabatan->id)selected @endif
                                            value="{{$jabatan->id}}">{{$jabatan->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Type User</label>
                                    <select name="type_user" id="type_user" class="form-control select2" required>
                                        <option @if($users->type_user == 2)selected @endif value="2">User</option>
                                        <option @if($users->type_user == 1)selected @endif value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control
                                    select2')) !!}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Branch</label>
                            <select name="branch" id="branch_e" class="form-control select2 branch_e" required>
                                <option value="" selected>Pilih Cabang</option>
                            </select>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Akun Bank</label>
                                    <select name="akun_bank_id[]" class="form-control select2" multiple>
                                        <option value="">Pilih Akun Bank</option>
                                        @foreach($akunss as $akun)
                                        <option value="{{$akun->id}}" @foreach($users->akunBank as $a)
                                            @if($akun->id == $a->id) selected @endif @endforeach
                                            >{{$akun->akun}} | {{$akun->branch_id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pemeriksa_kas_id">Nama Pemeriksa</label>
                                    <select name="pemeriksa_kas_id" id="pemeriksa_kas_id" class="form-control select2"
                                        required>
                                        @foreach($pemeriksa as $periksa)
                                        <option @if($users->pemeriksa_kas_id == $periksa->id)selected @endif
                                            value="{{$periksa->id}}">{{$periksa->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Branch</label>
                                <select name="branch" id="branch_e" class="form-control select2 branch_e" required>
                                    <option value="" selected>Pilih Cabang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Minimum Saldo</label>
                                <input class="form-control" type="text" id="minimum_saldo" name="minimum_saldo">
                            </div>
                        </div>
                    </div> -->
                        <!-- <div class="form-group">
                        <label for="">Office</label>
                        <select name="office" id="office_e" class="form-control select2 office_e" required>
                        <option value="" selected>Pilih Cabang Dulu</option>
                        </select>
                    </div> -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create"><i
                                    class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $.ajax({
                url: "https://pcpexpress.com/apiphp/api/api.branch.php",
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var str = "<option value='" + data[i].branch_id + "|" + data[i]
                            .branch_name + "'>" + data[i].branch_name +
                            "</option>";

                        $("#branch_e").append(str);
                    }

                },
                error: function (data) {
                    alert("tidak dapat memproses");
                }
            });
            $('#branch_e').each(function () {
                $(this).select2({
                    height: '300%',
                    width: '100%',
                    dropdownParent: $(this).parent()
                });
            })

            $('#office_e').each(function () {
                $(this).select2({
                    height: '300%',
                    width: '100%',
                    dropdownParent: $(this).parent()
                });
            })

        });

        $('.branch_e').on('change', function () {
            $(".office_e").html("");
            var type = $('.branch_e').val();
            var type_a = type.split("|");
            var id = type_a[0];
            $.ajax({
                url: "https://pcpexpress.com/apiphp/api/api.office.php",
                type: "Get",
                method: "Get",
                data: {
                    'id': id
                },
                dataType: 'json',
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var str = "<option value='" + data[i].office_id + "|" + data[i]
                            .office_name + "'>" + data[i].office_name + " " + data[i].office_id +
                            "</option>";
                        $(".office_e").append(str);
                    }
                },
            });
        });

    </script>
    @endsection
