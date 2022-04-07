@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Pengisian Kas Operasional</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pengisian-kas</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <form action="{{route('pemasukkan-kas.filter')}}" method="POST" id="frm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="mr-auto p-2">
                            @can('pengisian-create')
                            <a class="btn btn-outline-danger text-white shadow-sm" data-toggle="modal"
                                data-target="#exampleModal1">
                                <i class="fas fa-plus-circle text-white"></i> Input Pengisian Kas
                            </a>
                            @endcan
                            @can('pengisian-penyesuaian')
                            <a class="btn btn-success text-white" data-toggle="modal" data-target="#exampleModal2">
                                Penyesuaian Kas <i class="fas fa-plus-circle "></i>
                            </a>
                            @endcan
                        </div>
                        <div class="p-2">
                            <select name="req1" id="" class="form-control select2 status-dropdown "
                                style="cursor:pointer;" onchange="onSelectChange();">
                                <option value="" >-- Pilih Akun Bank --</option>
                                <option value="">All</option>
                                @foreach($akunBanks as $k)
                                <option value="{{$k->id}}">{{$k->akun}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="p-2">
                            <button class="btn btn-outline-danger btn-lg">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div> -->
                    </div>
                    <!-- <div id="table-filter" style="display:none">
                        <select class="form-control">
                            <option value="">All</option>
                            @foreach($akunBanks as $k)
                            <option>{{$k->akun}}</option>
                            @endforeach
                        </select>
                    </div> -->
            </form>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-lg tabel-data" id="tabel-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Akun Bank</th>
                                <th>Keterangan</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemasukkan as $i=>$p)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$p->no_transaksi}}</td>
                                <!-- <td><a href="{{route('pemasukkan-kas.edit',$p->id)}}" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i> Edit</a></td> -->
                                <td>{{date("d/m/Y", strtotime($p->tanggal_dikeluarkan))}}</td>
                                <td>{{$p->akun ?? ''}}</td>
                                <td>{{$p->keterangan}}</td>
                                <td class="text-success text-right">Rp.
                                    {{number_format($p->nominal,0,',','.')}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Total:</th>
                                <th></th>
                            </tr>
                        </tfoot> -->
                        <tr>
                                <th>Grand Total</th>
                                <td colspan="5" class="text-right">
                                    <strong>Rp.{{number_format($nominal_t,0,',','.')}}</strong></td>
                            </tr>
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
            ajax: "{{ route('pemasukkan-kas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',

                },
                {
                    data: 'tanggal_dikeluarkan',
                    name: 'tanggal_dikeluarkan'
                },
                {
                    data: 'akun',
                    name: 'akun'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },

                // {
                //     data: 'file',
                //     name: 'file'
                // },

            ],
            initComplete: function () {
            this.api().columns('.select-filter').every( function () {
                var column = this;
                var select = $('<select><option value="">--Pilih Akun Bank--</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
        "columnDefs": [
        { "searchable": false, "targets": [2, 5] }  // Disable search on first and last columns
        ]
        });

    });


</script> -->

<script>
    function onSelectChange(){
 document.getElementById('frm').submit();
}

</script>

@endsection
<!-- Modal Pemasukkan -->
<div class="modal fade" id="exampleModal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Kas Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('pemasukkan-kas.store')}}" method="POST">
                    @csrf
                    <!-- <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Kode BKU</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" id="dateDefault" name="tgl-bku">
                    </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Pengisian*</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="dateDefault" name="tanggal_dikeluarkan" required>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="staticEmail" class="col-sm-2 col-form-label">Akun Bank*</label>
                        <div class="col-sm-10">
                            <select name="akun_bank_id" id="" class="form-control select2" required>
                                <option value="">-- Pilih Akun Bank --</option>
                                @foreach($akunBanks as $a)
                                <option value="{{$a->id}}">{{$a->akun}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Nominal Biaya*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nominal" name="nominal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Keterangan *</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" required> </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-danger btn-block">Save changes</button>

                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary btn-block"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penyesuaian Saldo Tambah-->
<div class="modal fade" id="exampleModal2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Penyesuaian Kas Operasional Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('pemasukkan-kas.penyesuaian')}}" method="POST">
                    @csrf
                    <div class="form-group row">

                        <label for="staticEmail" class="col-sm-2 col-form-label">Type Penyesuaian <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select name="type_p" id="" class="form-control select2" required>
                                <option value="">-- Pilih Type Penyesuaian --</option>
                                <option value="tambah">Tambah</option>
                                <option value="kurang">Kurang</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="staticEmail" class="col-sm-2 col-form-label">Akun Bank <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select name="akun_bank_id" id="" class="form-control select2" required>
                                <option value="">-- Pilih Akun Bank --</option>
                                @foreach($akunBanks as $a)
                                <option value="{{$a->id}}">{{$a->akun}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Penyesuaian <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_dikeluarkan" name="tanggal_dikeluarkan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Nominal Penyesuaian <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nominal" name="nominal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Keterangan Penyesuaian Saldo <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" cols="30" required
                                rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-danger btn-block">Save changes</button>

                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary btn-block"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Penyesuaian Saldo tambah -->
<script>
    function setInputDate(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1,
        y = hoy.getFullYear(),
        data;

    if(d < 10){
        d = "0"+d;
    };
    if(m < 10){
        m = "0"+m;
    };

    data = y+"-"+m+"-"+d;
    console.log(data);
    _dat.value = data;
};

setInputDate("#dateDefault");
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
        <button type="submit" class="btn btn-outline-success">Save changes</button>
      </div>
        </form>
      </div>

    </div>
  </div>
</div> -->
