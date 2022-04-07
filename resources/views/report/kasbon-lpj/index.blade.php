@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Report LPJ Kasbon</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">LPJ Kasbon</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                <form action="{{route('report-lpj.report')}}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-3">
                                <div class="form-group">
                                <label for="">Akun Bank</label>
                                <select name="req2" id="" class="form-control select2">
                                    <option value="" class="bg-light text-dark">-- Pilih Akun Bank --</option>
                                    <option value="" class="bg-light text-dark">All</option>
                                    @foreach($akunBanks as $k)
                                    <option value="{{$k->id}}" class="bg-light text-dark">{{$k->akun}}</option>
                                    @endforeach
                            </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" class="form-control" name="tgl1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tgl2">
                                </div>
                            </div>
                            <div class="col-md-3">
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
                                    <th>No Kasbon</th>
                                    <th>Tanggal Kasbon</th>
                                    <th>Nama</th>
                                    <th>Keperluan</th>
                                    <th>Nilai</th>
                                    <th>Tanggal LPJ</th>
                                    <th>Nilai LPJ</th>
                                    <th>Refund</th>
                                    <th>status</th>
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
                                    <td>{{$report->no_transaksi}}</td>
                                    <td>{{date("d/m/Y", strtotime($report->tanggal_pengajuan))}}</td>
                                    <td>{{$report->nama}}</td>
                                    <td>{{$report->keterangan}}</td>
                                    <td>{{$report->nominal_cashbon}}</td>
                                    <td>{{$report->tanggal_lpj}}</td>
                                    <td>{{$report->nominal}}</td>
                                   
                                    <td class="text-dark text-right">{{$report->refund}}</td>
                                   
                                    <td>{{$report->status}}</td>
                                   
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
