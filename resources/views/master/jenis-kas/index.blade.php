@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Master Jenis Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('jenis-kas.index')}}">Jenis Kas</a></div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data Master Jenis Kas Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    @can('jkas-create')
                    <button class="btn btn-outline-danger" href="javascript:void(0)" id="createNewProduct">
                        <i class="fas fa-plus-circle"></i> Tambah Master Jenis Kas
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis Kas</th>
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
            ajax: "{{ route('jenis-kas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'jenis_kas',
                    name: 'jenis_kas'
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
            $('#jenis_kas').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        $('body').on('click', '.editProduct', function () {
            var jenis_kas_id = $(this).data('id');
            $.get("{{ route('jenis-kas.index') }}" + '/' + jenis_kas_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#jenis_kas_id').val(data.id);
                $('#jenis_kas').val(data.jenis_kas);
            })
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save Changes');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('jenis-kas.store') }}",
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
            var jenis_kas_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('jenis-kas.store') }}" + '/' + jenis_kas_id,
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
<!-- Modal Tambah Master jabatan -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Master Jenis Kas</h5>
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
                    <input type="hidden" name="jenis_kas_id" id="jenis_kas_id">
                    <div class="form-group">
                        <label for="">Jenis Kas</label>
                        <input class="form-control" type="text" id="jenis_kas" name="jenis_kas">
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
        <form action="{{route('jabatan.store')}}" method="post">
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
