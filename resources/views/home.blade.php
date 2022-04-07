@extends('layouts.base')

@section('content')

<style type="text/css">
    .display-none {
        display: none;
    }

</style>

<div class="section-body">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{route('akun-bank.index')}}">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sisa Saldo</h4>
                        </div>
                        <div class="card-body">
                            <h6>Rp. {{number_format($sisa_saldo,0,',','.')}}</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" id="1" style="cursor:pointer;">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>

                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Cabang Saldo Minimum</h4>
                    </div>
                    <div class="card-body">
                        {{$saldo_minimum_sum}}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <a href="{{route('pemakaian-kas.index')}}">
                            <h4>Pemakaian Kas Operasional</h4>
                        </a>
                    </div>
                    <div class="card-body">
                        {{$jumlah_pengeluaran}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12" id="2" style="cursor:pointer;">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Posting > 30 Hari</h4>
                    </div>
                    <div class="card-body">
                        {{$expired_posting_count}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card display-none" id="card_posting">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-lg tabel-data" id="tabel-data1">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>Aksi</th> -->
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
                    @foreach($expired_posting as $i=>$p)
                    <tr class="bg-danger text-white">
                        <td>{{++$i}}</td>
                        <!-- <td><a href="{{route('pemakaian-kas.edit',$p->id)}}" class="btn btn-dark btn-sm"><i
                                    class="fas fa-edit"></i> Edit</a></td> -->
                        <td>{{date("d/m/Y", strtotime($p->tanggal_dikeluarkan))}}</td>
                        <td>{{$p->no_nota}}</td>
                        <td>{{$p->nama_penerima}}</td>
                        <td>{{$p->sub_akun_transaksi}}</td>
                        <td>{{$p->keterangan}}</td>
                        <td>{{date("d/m/Y", strtotime($p->tanggal_nota))}}</td>
                        <td>{{$p->akun ?? ''}}</td>
                        <td class="text-right">
                            <div class="text-white">{{number_format($p->nominal,0,',','.')}}</div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>
<div class="card display-none" id="card_show">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md" id="tabel-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Branch </th>
                        <th>Cabang Utama</th>
                        <th>Nama Akun Kas</th>
                        <th>No Rek Mandiri</th>
                        <th>Saldo </th>
                        <th>Saldo Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saldo_minimum as $i=>$saldo)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$saldo->branch_id}}</td>
                        <td>{{$saldo->branch_alias}}</td>
                        <td>{{$saldo->akun}}</td>
                        <td>{{$saldo->rek_akun}}</td>
                        <td class="text-danger">Rp.{{number_format($saldo->saldo,0,',','.')}}</td>
                        <td>Rp.{{number_format($saldo->saldo_minimum,0,',','.')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#tabel-data').DataTable({
        // "ordering": false,
        // "searching": false,
        "lengthChange": false
    });

</script>
<script>
    $('#tabel-data1').DataTable({
        // "ordering": false,
        // "searching": false,
        "lengthChange": false
    });

</script>
<script type="text/javascript">
    $("#1").click(function () {
        $("#card_show").toggleClass('display-none');
    });
    $("#2").click(function () {
        $("#card_posting").toggleClass('display-none');
    });

</script>


@endsection
