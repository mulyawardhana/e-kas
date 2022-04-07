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
                    @can('user-create')
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus-circle"></i> Tambah User
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table" id="tabel-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Pemeriksa Kas</th>
                                    <th>Akun Bank</th>
                                    <th>Roles</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $i => $akun)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$akun->username}}</td>
                                    <td>{{$akun->name}}</td>
                                    <td>{{$akun->jabatan->nama_jabatan ?? ''}}</td>
                                    <td>{{$akun->pemeriksa->nama ?? ''}}</td>
                                    <td>
                                        @foreach($akun->akunBank as $a)
                                        <span class="badge badge-success mb-1">{{$a->akun ?? ''}}</span><br />
                                        @endforeach</td>
                                        <td>@if(!empty($akun->getRoleNames()))
                                    @foreach($akun->getRoleNames() as $v)
                                        <label class="badge badge-info">{{ $v }}</label>
                                    @endforeach
                                    @endif</td>
                                    <td>
                                    @can('user-edit')
                                        <a href="{{route('user.edit',$akun->id)}}" class="btn btn-dark btn-sm"><i
                                                class="fas fa-edit"></i> Edit</a>
                                    @endcan

                                    </td>
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

<!-- <script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'branch_id',
                    name: 'branch_id'
                },
                {
                    data: 'branch_name',
                    name: 'branch_name'
                },
                {
                    data: 'minimum_saldo',
                    name: 'minimum_saldo'
                },
                // {
                //     data: 'office_id',
                //     name: 'office_id'
                // },
                // {
                //     data: 'office_name',
                //     name: 'office_name'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('#createNewProduct').click(function () {
            $('#saveBtn').val("create-product");
            $('#user_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        $('body').on('click', '.editProduct', function () {
            var user_id = $(this).data('id');
            $.get("{{ route('user.index') }}" + '/' + user_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#nik').val(data.nik);
                $('#email').val(data.email);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#branch_id').val(data.branch_id);
                $('#branch_name').val(data.branch_name);
                $('#minimum_saldo').val(data.minimum_saldo);
                // $('#office_id').val(data.office_id);
                // $('#office_name').val(data.office_name);
            })
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save Changes');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('user.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.errors) {
                        $('.alert-danger').html('');
                        $.each(data.errors, function (key, value) {

                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                            setInterval(function () {
                                $('.alert-danger').hide();
                            }, 5000);

                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function () {
                            $('.alert-success').hide();
                        }, 5000);
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    }
                },

            });
        });

    });

</script>
<script type="text/javascript">
    $(function () {
        $.ajax({
            url: "http://pcpexpress.com/apiphp/api/api.branch.php",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var str = "<option value='" + data[i].branch_id + "|" + data[i].branch_name + "'>" + data[i].branch_name +
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
            url: "http://pcpexpress.com/apiphp/api/api.office.php",
            type: "Get",
            method: "Get",
            data: {
                'id': id
            },
            dataType: 'json',
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var str = "<option value='" + data[i].office_id + "|" + data[i].office_name +"'>" + data[i].office_name + " " + data[i].office_id + "</option>";
                    $(".office_e").append(str);
                }
            },
        });
    });

</script> -->
<script type="text/javascript">
    $(function () {
        $.ajax({
            url: "https://pcpexpress.com/apiphp/api/api.branch.php",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var str = "<option value='" + data[i].branch_id + "'>" + data[i].branch_name +
                        "</option>";

                    $("#branch_e").append(str);
                }

            },
            error: function (data) {
                alert("tidak dapat memproses");
            }
        });

    });

</script>
<script>
    $(document).ready(function () {
        $('#branch_e').on('change', function () {
            var branch_id = $(this).val();
            if (branch_id) {
                $.ajax({
                    url: '/getAkun/' + branch_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            $('#akun').empty();
                            $('#akun').append('<option disabled>Pilih Akun Bank</option>');
                            $.each(data, function (key, branch_id) {
                                console.log(data)
                                $('select[name="akun_bank_id[]"]').append(
                                    '<option value="' + branch_id.id + '">' +
                                    branch_id.akun + ' | ' + branch_id
                                    .rek_akun + '</option>');
                            });
                        } else {
                            $('#akun').empty();
                        }
                    }
                });
            } else {
                $('#akun').empty();
            }
        });
    });

</script>
@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Master User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="productForm" name="productForm" class="form-horizontal"> -->
                <form action="{{route('user.store')}}" method="POST">
                    @csrf
                    <!-- <input type="hidden" name="user_id" id="user_id"> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control" type="text" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control select2" required>
                                    <option value="">--Pilih Jabatan--</option>
                                    @foreach($jabatans as $jabatan)
                                    <option value="{{$jabatan->id}}">{{$jabatan->nama_jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="roles" class="form-control select2" >
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Type User</label>
                                <select name="type_user" id="type_user" class="form-control select2" required>
                                    <option value="2">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Pemeriksa Kas</label>
                                <select name="pemeriksa_kas_id" id="pemeriksa_kas_id" class="form-control select2" required>
                                    <option value="">--Pilih Pemeriksa Kas--</option>
                                    @foreach($pemeriksa as $periksa)
                                    <option value="{{$periksa->id}}">{{$periksa->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Branch</label>
                        <select name="branch" id="branch_e" class="form-control select2 branch_e" required>
                            <option value="" selected>Pilih Cabang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="akun" class="form-label">Akun Bank</label>
                        <select name="akun_bank_id[]" class="form-control select2" multiple id="akun"></select>
                    </div>
                    <!-- <div class="form-group">
                    <label for="">Akun Bank</label>
                        <select name="akun_bank_id[]" class="form-control select2" multiple>
                            <option value="">Pilih Akun Bank</option>
                            @foreach($akuns as $a)
                            <option value="{{$a->id}}">{{$a->akun}}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input class="form-control" type="text" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input class="form-control" type="password" id="password" name="password" required>
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
                        <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('klasifikasi.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Kode Akun</label>
                <input class="form-control" type="text" name="kode_akun">
            </div>
            <div class="form-group">
                <label for="">Nama Akun</label>
                <input class="form-control" type="text" name="nama_akun">
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
        </form>
      </div>

    </div>
  </div>
</div> -->
