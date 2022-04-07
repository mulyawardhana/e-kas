@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Master Akun Bank</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('akun-bank.index')}}">Akun-Bank</a></div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data Master Akun Bank Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                @can('akun-bank-create')
                    <button class="btn btn-outline-danger" href="javascript:void(0)" id="createNewProduct">
                        <i class="fas fa-plus-circle"></i> Tambah Master Akun Bank
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Branch </th>
                                    <th>Cabang Utama</th>
                                    <th>Nama Akun Kas</th>
                                    <th>No Rek Mandiri</th>
                                    <th>Saldo </th>
                                    <th>Saldo Minimum</th>
                                    <th>No COA Jurnalku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('akun-bank.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'branch_id',
                    name: 'branch_id'
                },
                {
                    data: 'branch_alias',
                    name: 'branch_alias'
                },
                {
                    data: 'akun',
                    name: 'akun'
                },
                {
                    data: 'rek_akun',
                    name: 'rek_akun'
                },
                {
                    data: 'saldo',
                    name: 'saldo'
                },
                {
                    data: 'saldo_minimum',
                    name: 'saldo_minimum'
                },
                {
                    data: 'no_coa',
                    name: 'no_coa'
                },
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
            $('#akun_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        $('body').on('click', '.editProduct', function () {
            var akun_id = $(this).data('id');
            $.get("{{ route('akun-bank.index') }}" + '/' + akun_id + '/edit', function (data) {

                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#akun_id').val(data.id);
                $('#branch_id').val(data.branch_id);
                $('#branch_alias').val(data.branch_alias);
                $('#akun').val(data.akun);
                $('#rek_akun').val(data.rek_akun);
                $('#saldo_minimum').val(data.saldo_minimum);
                $('#saldo').val(data.saldo);
                $('#no_coa').val(data.no_coa);
            })
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save Changes');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('akun-bank.store') }}",
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
                            }, 3000);

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
        $('body').on('click', '.deleteProduct', function () {
            var akun_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('akun-bank.store') }}" + '/' + akun_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } else {
                return false;
            }
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
                    var str = "<option value='" + data[i].branch_id + "'>" + data[i].branch_name +
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

</script>
@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Master Akun Bank</h5>
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
                <form id="productForm" name="productForm" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                        <input type="hidden" name="akun_id" id="akun_id">
                    <div class="form-group">
                        <label for="">Branch</label>
                        <select name="branch_id" id="branch_e" class="form-control select2 branch_e" required>
                            <option value="" selected>Pilih Cabang</option>
                        </select>
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="">Cabang Utama</label>
                        <input class="form-control" type="text" id="branch_alias" name="branch_alias">
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="">Nama Akun Kas</label>
                        <input class="form-control" type="text" id="akun" name="akun">
                    </div>
                        </div>
                        <div class="col-md-6">

                    <div class="form-group">
                        <label for="">No Rekening Mandiri</label>
                        <input class="form-control" type="text" id="rek_akun" name="rek_akun">
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="">Saldo Minimum</label>
                        <input class="form-control" type="text" id="saldo_minimum" name="saldo_minimum">
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="">Nomor COA - Djurnalku</label>
                        <input class="form-control" type="text" id="no_coa" name="no_coa">
                    </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Saldo</label>
                        <input class="form-control" type="text" id="saldo" name="saldo">
                    </div> -->

                    <div class="row">
                        <div class="col-md-12">
                        <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create">Save changes</button>
                        </div>
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
