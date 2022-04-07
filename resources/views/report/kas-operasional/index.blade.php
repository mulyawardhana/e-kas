@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Report Kas Operasional</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('report.kas-operasional')}}">Kas-operasional</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                <form action="{{route('report.kas-operasional')}}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-3">
                                <div class="form-group">
                                <label for="">Akun Bank</label>
                                <select name="req2" id="" class="form-control select2">
                                    <option value="all" class="bg-light text-dark">-- Pilih Akun Bank --</option>
                                    <option value="all" class="bg-light text-dark">All</option>
                                    @foreach($akunBanks as $k)
                                    <option value="{{$k->id}}" class="bg-light text-dark">{{$k->akun}}</option>
                                    @endforeach
                            </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                   <select name="req1" id="" class="form-control select2">
                                        <option value="all">--Pilih Deskripsi--</option>
                                       <option value="all">All</option>
                                       <option value="pemasukkan">Pemasukkan</option>
                                       <option value="pengeluaran">Pengeluaran</option>
                                       <option value="posting">Posting</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" class="form-control" name="tgl1">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tgl2">
                                </div>
                            </div>
                            <div class="col-md-2">
                            <label for="">&nbsp;</label>
                                <div class="form-group"><button class="btn btn-danger btn-block" type="submit"><i class="fas fa-filter"></i>   Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                   
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table" id="tabel-data" style="font-size:10px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Akun Bank</th>
                                    <th>Tanggal</th>
                                    <th>Nomor Nota</th>
                                    <th>Nama Penerima</th>
                                    <th>Sub Akun Transaksi</th>
                                    <th>Keterangan</th>
                                    <th>Deskripsi</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Saldo</th>
                                    <!-- <th>Attachment</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $prev = 0;
                                @endphp
                                @foreach($reports as $i=>$report)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$report->akun}}</td>
                                    <td>{{date("d/m/Y", strtotime($report->tanggal_dikeluarkan))}}</td>
                                    <td>{{$report->no_nota}}</td>
                                    <td>{{$report->nama_penerima}}</td>
                                    <td>{{$report->sub_akun_transaksi ?? ''}}</td>
                                    <td>{{$report->keterangan}}</td>
                                    @if($report->deskripsi == 'pemasukkan')
                                    <td><div class="badge badge-success">{{$report->deskripsi}}</div></td>
                                    @elseif($report->deskripsi == 'pengeluaran')
                                    <td><div class="badge badge-warning">{{$report->deskripsi}}</div></td>
                                    @else($report->deskripsi == 'posting')
                                    <td><div class="badge badge-danger">{{$report->deskripsi}}</div></td>
                                    @endif
                                    @if($report->deskripsi == 'pemasukkan')
                                    <td class="text-success text-right">+ {{number_format($report->nominal,0,',','.')}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    @if($report->deskripsi == 'pengeluaran')
                                    <td class="text-danger text-right">{{number_format($report->nominal,0,',','.')}}</td>
                                    @elseif($report->deskripsi == 'posting')
                                    <td class="text-warning text-right">{{number_format($report->nominal,0,',','.')}}</td>
                                    @else 
                                   <td></td>
                                    @endif
                                    <td class="text-dark text-right">{{number_format($report->nominal + $prev,0,',','.')}}</td>
                                    <!-- @if($report->deskripsi !== '')
                                    <td>{{number_format($report->saldo,0,',','.')}}</td>
                                    @else 
                                    <td>-</td>
                                    @endif -->
                                   
                                </tr>
                                @php
                                $prev = $report->nominal + $prev
                                @endphp
                                @endforeach
                            </tbody>
                            <!-- <tr>
                                <td colspan="2">Total</td>
                                <td colspan="8" class="text-right"><strong>Rp.
                                      </strong>
                                </td>
                            </tr> -->
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


@endsection
