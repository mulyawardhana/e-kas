@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Master Branch</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">Branch</a></div>
    </div>
</div>
<!-- <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data User Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div> -->
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus-circle"></i> Tambah Branch
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table" id="tabel-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Branch Name</th>
                                    <th>Akun Bank</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mbranchs as $i => $mb)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$mb->branch_name}}</td>
                                    <td>
                                        @foreach($mb->akunBank as $a)
                                        <li class="text-danger">{{$a->akun ?? ''}}</li>
                                        @endforeach</td>
                                    
                                    <td>
                                        <!-- <a href="{{route('user.show',$akun->id)}}" class="btn btn-warning">Detail</a> -->
                                        TODO
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

@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Master Branch</h5>
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
                    <form action="{{route('mbranch.store')}}" method="POST">
                    @csrf
                    <!-- <input type="hidden" name="user_id" id="user_id"> -->

                    <div class="form-group">
                        <label for="">Branch Name</label>
                        <input class="form-control" type="text" id="name" name="branch_name">
                    </div>
                    <div class="form-group">
                    <label for="">Akun Bank</label>
                        <select name="akun_bank_id[]" id="branch_e" class="form-control select2" multiple>
                            <option value="">Pilih Akun Bank</option>
                            @foreach($akunBanks as $a)
                            <option value="{{$a->id}}">{{$a->akun}}</option>
                            @endforeach
                        </select>
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
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
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
