@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Pertanggung Jawaban Kasbon</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pertanggungjawaban.index')}}">Pertanggungjawaban</a></div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Success! </strong>Data Pertanggungjawaban Berhasil di Tambahkan!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    @can('pertanggungjawaban-create')
                    <a href="{{route('pertanggungjawaban.create')}}" class="btn btn-danger">
                        <i class="fas fa-plus-circle"></i> Tambah Pertanggungjawaban
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal LPJ</th>
                                    <th>No Kasbon</th>
                                    <th>Nilai</th>
                                    <th>Nilai LPJ</th>
                                    <th>Refund Dana</th>
                                    <th>Selisih</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <!-- <th>Aksi</th> -->
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
            ajax: "{{ route('pertanggungjawaban.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tanggal_lpj',
                    name: 'tanggal_lpj'
                },
                {
                    data: 'no_transaksi',
                    name: 'no_transaksi'
                },
                {
                    data: 'nominal_kasbon',
                    name: 'nominal_kasbon'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'refund',
                    name: 'refund'
                },
                {
                    data: 'selisih',
                    name: 'selisih'
                },
                {
                    data: 'action',
                    name: 'action'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ]
        });
        // $('#createNewProduct').click(function () {
        //     $('#saveBtn').val("create-product");
        //     $('#kasbon_id').val('');
        //     $('#productForm').trigger("reset");
        //     $('#modelHeading').html("Create New Product");
        //     $('#ajaxModel').modal('show');
        // });
        // $('body').on('click', '.editProduct', function () {
        //     var kasbon_id = $(this).data('id');
        //     console.log(kasbon_id)
        //     $.get("{{ route('kasbon.index') }}" + '/' + kasbon_id + '/edit', function (data) {
        //         console.log(data)
        //         $('#modelHeading').html("Edit Product");
        //         $('#saveBtn').val("edit-user");
        //         $('#ajaxModel').modal('show');
        //         $('#kasbon_id').val(data.id);
        //         $('#akun_bank_id').val(data.akun_bank_id);
        //         $('#tanggal_pengajuan').val(data.tanggal_pengajuan);
        //         $('#keterangan').val(data.keterangan);
        //         $('#nominal').val(data.nominal);
        //     })
        // });
        // $('#saveBtn').click(function (e) {
        //     e.preventDefault();
        //     $(this).html('Save Changes');

        //     $.ajax({
        //         data: $('#productForm').serialize(),
        //         url: "{{ route('kasbon.store') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         success: function (data) {
        //             if (data.errors) {
        //                 $('.alert-danger').html('');
        //                 $.each(data.errors, function (key, value) {

        //                     $('.alert-danger').show();
        //                     $('.alert-danger').append('<strong><li>' + value +
        //                         '</li></strong>');
        //                     setInterval(function () {
        //                         $('.alert-danger').hide();
        //                     }, 3000);

        //                 });
        //             } else {
        //                 $('.alert-danger').hide();
        //                 $('.alert-success').show();
        //                 $('.datatable').DataTable().ajax.reload();
        //                 setInterval(function () {
        //                     $('.alert-success').hide();
        //                 }, 5000);
        //                 $('#productForm').trigger("reset");
        //                 $('#ajaxModel').modal('hide');
        //                 table.draw();
        //             }
        //         },

        //     });
        // });
        // $('body').on('click', '.deleteProduct', function () {
        //     var kasbon_id = $(this).data("id");
        //     var result = confirm("Are You sure want to delete !");
        //     if (result) {
        //         $.ajax({
        //             type: "DELETE",
        //             url: "{{ route('kasbon.store') }}" + '/' + kasbon_id,
        //             success: function (data) {
        //                 table.draw();
        //             },
        //             error: function (data) {
        //                 console.log('Error:', data);
        //             }
        //         });
        //     } else {
        //         return false;
        //     }
        // });
    });

</script>

@endsection
