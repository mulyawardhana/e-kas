@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Kasbon</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('kasbon.index')}}">kasbon</a></div>
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
                    @can('cashbon-create')
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus-circle"></i> Tambah Kasbon
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Kasbon</th>
                                    <th>Akun Bank</th>
                                    <th>Nama</th>
                                    <th>Tanggal Kasbon</th>
                                    <th>Keterangan Kasbon</th>
                                    <th>Nominal</th>
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
            ajax: "{{ route('kasbon.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_transaksi',
                    name: 'no_transaksi'
                },
                {
                    data: 'akun',
                    name: 'akun'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'tanggal_pengajuan',
                    name: 'tanggal_pengajuan'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
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
<script>
    var rupiah = document.getElementById("nominal");
    rupiah.addEventListener("keyup", function (e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, "Rp. ");
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }

</script>
@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Kasbon</h5>
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
                <form action="{{route('kasbon.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <input type="hidden" name="kasbon_id" id="kasbon_id"> -->
                            <div class="form-group">
                                <label for="">Akun Bank</label>
                                <select name="akun_bank_id" id="akun_bank_id" class="form-control select2">
                                    <option value="">-- Pilih Akun Banks --</option>
                                    @foreach($akuns as $akun)
                                    <option value="{{$akun->id}}">{{$akun->akun}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal kasbon</label>
                                <input class="form-control" type="date" id="tanggal_pengajuan" name="tanggal_pengajuan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="">Nama</label>
                                <input class="form-control" type="text" id="nama" name="nama">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="">Keperluan</label>
                                <textarea class="form-control" type="text" id="keterangan" name="keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="">Nominal Kasbon</label>
                                <input class="form-control" type="text" id="nominal" name="nominal">
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
                        <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create">Save
                            changes</button>
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
