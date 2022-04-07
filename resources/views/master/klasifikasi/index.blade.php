@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Master Klasifikasi Akun</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('klasifikasi.index')}}">Klasifikasi-Akun</a></div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data Master Akun Klasifikasi Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-danger" href="javascript:void(0)" id="createNewProduct">
                        <i class="fas fa-plus-circle"></i> Tambah Master Klasifikasi
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Akun Induk</th>
                                    <th>Nama Akun Induk</th>
                                    <th>Sub AKun Induk</th>
                                    <th>Sub Akun Transaksi</th>
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
            ajax: "{{ route('klasifikasi.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_akun_induk',
                    name: 'no_akun_induk'
                },
                {
                    data: 'nama_akun_induk',
                    name: 'nama_akun_induk'
                },
                {
                    data: 'sub_akun_induk',
                    name: 'sub_akun_induk'
                },
                {
                    data: 'sub_akun_transaksi',
                    name: 'sub_akun_transaksi'
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
            $('#klasifikasi_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        $('body').on('click', '.editProduct', function () {
            var klasifikasi_id = $(this).data('id');
            $.get("{{ route('klasifikasi.index') }}" + '/' + klasifikasi_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#klasifikasi_id').val(data.id);
                $('#no_akun_induk').val(data.no_akun_induk);
                $('#nama_akun_induk').val(data.nama_akun_induk);
                $('#sub_akun_induk').val(data.sub_akun_induk);
                $('#sub_akun_transaksi').val(data.sub_akun_transaksi);
            })
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save Changes');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('klasifikasi.store') }}",
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
            var klasifikasi_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('klasifikasi.store') }}" + '/' + klasifikasi_id,
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
@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Master Akun Klasifikasi</h5>
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
                    <input type="hidden" name="klasifikasi_id" id="klasifikasi_id">
                    <div class="form-group">
                        <label for="">No Akun Induk</label>
                        <input class="form-control" type="text" id="no_akun_induk" name="no_akun_induk">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Akun Induk</label>
                        <input class="form-control" type="text" id="nama_akun_induk" name="nama_akun_induk">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Akun Induk</label>
                        <input class="form-control" type="text" id="sub_akun_induk" name="sub_akun_induk">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Akun Transaksi</label>
                        <input class="form-control" type="text" id="sub_akun_transaksi" name="sub_akun_transaksi">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create"><i class="fas fa-save"></i> Save changes</button>
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
