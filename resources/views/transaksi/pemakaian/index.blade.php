@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Pemakaian Kas Operasional</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form action="{{route('pemakaian-kas.filter')}}" method="POST" id="frm">
                    @csrf
                    <div class="card-header d-flex">
                        <div class="mr-auto p-2">
                            @can('pemakaian-create')
                            <a class="btn  btn-outline-danger"
                                href="{{route('pemakaian-kas.create')}}">
                                <i class="fas fa-plus-circle"></i> Input Pemakaian Kas
                            </a>
                            @endcan
                        </div>

                        <div class="p-2">
                            <select name="req1" id="" class="form-control select2" style="cursor:pointer;" onchange="onSelectChange();">
                                <option value="" class="bg-light text-dark">-- Pilih Akun Bank --</option>
                                <option value="" class="bg-light text-dark">All</option>
                                @foreach($akunBanks as $k)
                                <option value="{{$k->id}}" class="bg-light text-dark">{{$k->akun}} | Saldo Rp.
                                    {{number_format($k->saldo,0,',','.')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="p-2">
                            <button class="btn  btn-outline-danger btn-lg">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div> -->
                    </div>
                </form>
                <div class="card-body">
                    @foreach($gtkas_saldo_minimum as $s)
                    @if($s->saldo < $s->saldo_minimum)
                        <div class="alert alert-danger alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">Mohon Segera isi kembali saldo kas! Akun Bank:
                                {{$s->akun ?? ''}}|{{$s->rek_akun ?? ''}}
                            </div>
                        </div>
                    @else
                    @endif
                    @endforeach
                        <div class="table-responsive">
                            <table class="table table-bordered table-lg tabel-data" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Tanggal</th>
                                        <th>Nomor Nota</th>
                                        <th>Nama Penerima</th>
                                        <th>Sub Akun Transaksi</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Nota</th>
                                        <th>Akun Banks</th>
                                        <th>Nominal</th>
                                        <!-- <th>Attachment</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengeluarans as $i=>$p)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                        @can('pemakaian-create')
                                            <a href="{{route('pemakaian-kas.edit',$p->id)}}"
                                                class="btn btn-dark btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                @endcan
                                        </td>
                                        <td>{{date("d/m/Y", strtotime($p->tanggal_dikeluarkan))}}</td>
                                        <td>{{$p->no_nota}}</td>
                                        <td>{{$p->nama_penerima}}</td>
                                        <td>{{$p->sub_akun_transaksi}}</td>
                                        <td>{{$p->keterangan}}</td>
                                        <td>{{date("d/m/Y", strtotime($p->tanggal_nota))}}</td>
                                        <td>{{$p->akun ?? ''}}</td>
                                        <td class="text-right">
                                            <div class="text-danger">{{number_format($p->nominal,0,',','.')}}</div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <th colspan="4" class="bg-warning text-right text-white"><i>Total Pengeluaran
                                            Sebelum Posting </i></th>
                                    <td colspan="9" class="bg-warning text-right text-white">
                                        <strong>
                                            <div class="text-white">Rp. {{number_format($nominal_t,0,',','.')}}</div>
                                        </strong></td>
                                </tr>
                            </table>

                        </div>
                </div>

            </div>
        </div>

    </div>

</div>
<script>
    function onSelectChange(){
 document.getElementById('frm').submit();
}
</script>
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
            ajax: "{{ route('pemakaian-kas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_dikeluarkan',
                    name: 'tanggal_dikeluarkan'
                },
                {
                    data: 'no_nota',
                    name: 'no_nota'
                },
                {
                    data: 'nama_penerima',
                    name: 'nama_penerima'
                },
                {
                    data: 'sub_akun_transaksi',
                    name: 'sub_akun_transaksi'
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
                    data: 'tanggal_nota',
                    name: 'tanggal_nota'
                },
                // {
                //     data: 'file',
                //     name: 'file'
                // },
                {
                    data: 'action',
                    name: 'action',

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
                $('#sub_akun_transaksi').val(data.sub_akun_transaksi);
                $('#kode_akun').val(data.kode_akun);
                $('#nama_akun').val(data.nama_akun);
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
                    $('#productForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });
    });

</script>
@endsection
<!-- Modal Tambah Master Klasifikasi -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="klasifikasi_id" id="klasifikasi_id">
                    <div class="form-group">
                        <label for="">Kode Akun</label>
                        <input class="form-control" type="text" id="kode_akun" name="kode_akun">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Akun</label>
                        <input class="form-control" type="text" id="nama_akun" name="nama_akun">
                    </div>
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
