@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Posting Kas Operasional</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('report.posting')}}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Akun Bank</label>
                                   <select name="req1" id="" class="form-control select2">
                                        <option value="">--Pilih Akun Bank--</option>
                                        <option value="">--Pilih All--</option>
                                   @foreach($akunBanks as $akun)
                                        <option value="{{$akun->id}}">{{$akun->akun}}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Tanggal Awal</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="tgl1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Tanggal Akhir</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="tgl2">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">&nbsp;</label>
                                <div class="form-group"><button class="btn btn-danger btn-block"
                                        type="submit"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <form action="{{route('report.posting')}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <!-- <a href="#" class="btn btn-danger mb-2"><i class="fas fa-print"></i> Print</a> -->
                        <div class="table-responsive">
                            <!-- <button type="submit" id="submit_check"  class="btn btn-primary btn-block">Posting</button> -->
                            <table class="table table-bordered table-lg tabel-data" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>

                                            <input type="checkbox" id="selectAll" name="id[]">


                                        </th>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Akun Bank</th>
                                        <th>Nomor Nota</th>
                                        <th>Nama Penerima</th>
                                        <th>Jenis Biaya</th>
                                        <th>Keterangan</th>
                                        <th>Nominal</th>
                                        <th>Tanggal Nota</th>
                                        <!-- <th>Attachment</th> -->
                                        <!-- <th>Aksi</th> -->
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postings as $i=>$k)
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input type="checkbox" id="tr-checkbox1" name="id[]"
                                                    value="{{$k->id}}">
                                            </div>
                                        </td>
                                        <td>{{++$i}}</td>
                                        <td>{{date("d/m/Y", strtotime($k->tanggal_dikeluarkan))}}</td>
                                        <td>{{$k->akun}}</td>
                                        <td>{{$k->no_nota}}</td>
                                        <td>{{$k->nama_penerima}}</td>
                                        <td>{{$k->sub_akun_transaksi}}</td>
                                        <td>{{$k->keterangan}}</td>
                                        <td class="text-danger">Rp. {{number_format($k->nominal,0,',','.')}}</td>
                                        <td>{{date("d/m/Y", strtotime($k->tanggal_nota))}}</td>
                                        <td>{{$k->deskripsi}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(count($postings) !== 0)
                        <button type="submit" class="btn btn-danger btn-block mb-1"><i class="fas fa-sticky-note"></i> Posting</button> 
                        @else 
                       
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#tabel-data').DataTable({
                "scrollY": "400px",
                "scrollCollapse": true,
                "paging": false,
                "dom": 'fr<"testdiv">tip'
            });
            // $("div.testdiv").html(
            //     '<div style="float: left">  <button type="submit" id="submit_check"  class="btn btn-danger mb-1"><i class="fas fa-sticky-note"></i> Posting</button> </div>'
            //     );
        });

    </script>
    <script>
        $(document).ready(function () {
            var $selectAll = $('#selectAll'); // main checkbox inside table thead
            var $table = $('.table'); // table selector 
            var $tdCheckbox = $table.find('tbody input:checkbox'); // checboxes inside table body
            var tdCheckboxChecked = 0; // checked checboxes

            // Select or deselect all checkboxes depending on main checkbox change
            $selectAll.on('click', function () {
                $tdCheckbox.prop('checked', this.checked);
            });

            // Toggle main checkbox state to checked when all checkboxes inside tbody tag is checked
            $tdCheckbox.on('change', function (e) {
                tdCheckboxChecked = $table.find('tbody input:checkbox:checked')
                    .length; // Get count of checkboxes that is checked
                // if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
                $selectAll.prop('checked', (tdCheckboxChecked === $tdCheckbox.length));
            })
        });

    </script>
    <script>
        $(document).ready(function () {
            var $submit = $("#submit_check").hide(),
                $cbs = $('input[name="id[]"]').click(function () {
                    $submit.toggle($cbs.is(":checked"));
                });

        });

    </script>
    @endsection
    <!-- Modal Tambah Master Klasifikasi -->

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
