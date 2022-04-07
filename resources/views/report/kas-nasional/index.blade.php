@extends('layouts.base')

@section('content')
@php 
$years = range(2020, strftime("%Y", time()));
@endphp
<div class="section-header">
    <h1>Report Kas Operasional Nasional</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Kas-Nasional</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('report.nasional')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <select name="branch_id" id="branch_e" class="form-control select2 branch_e">
                                    <option value="" selected>Pilih Cabang</option>
                                    <option value="all" selected>Pilih All</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <select id="month" name="month" class="form-control">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <input type="month" class="form-control" name="tgl1">
                                </div>
                            </div> -->
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                <select class="form-control" name="year">
                                    <option>Select Year</option>
                                   @foreach($years as $year)
                                        <option value="{{$year}}">{{$year}}</option>
                                   @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-3">
                                <div class="form-group"><button class="btn btn-danger btn-lg"
                                        type="submit"><i class="fas fa-filter"> </i> Filter</button>
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
                        <table class="table table-bordered table-md data-table" id="tabel-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Branch Name</th>
                                    <th>Akun Bank</th>
                                    <th>Rek Bank</th>
                                    <th>Saldo</th>

                                    <!-- <th>Attachment</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $i=>$report)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$report->branch_id}}</td>
                                    <td>{{$report->akun}}</td>
                                    <td>{{$report->rek_akun}}</td>
                                    @if($report->saldo_minimum < $report->saldo)
                                    <td class="text-success text-right">Rp. {{number_format($report->saldo,0,',','.')}}</td>
                                    @else 
                                    <td class="text-danger text-right">{{number_format($report->saldo,0,',','.')}}</td>
                                    @endif
                                    
                                    <!-- @if($report->deskripsi == 'pemasukkan')
                                    <td class="text-success">+ {{$report->nominal}}</td>
                                    @else
                                    <td class="text-danger">{{$report->nominal}}</td>
                                    @endif -->

                                </tr>
                                @endforeach
                            </tbody>
                            <tr>
                                <td colspan="2">Total</td>
                                <td colspan="5" class="text-right"><strong>Rp.
                                {{number_format($reports1,0,',','.')}}       </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
    $(function () {
        $.ajax({
            url: "http://pcpexpress.com/apiphp/api/api.branch.php",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var str = "<option value='" + data[i].branch_id + "'>" + data[i].branch_name +
                        "</option>";

                    $("#branch_e").append(str);
                }

            },
            error: function (data) {
                alert("tidak dapat memproses");
            }
        });
        $('#branch_e').each(function () {
            $(this).select2({
                height: '300%',
                width: '100%',
                dropdownParent: $(this).parent()
            });
        })

        $('#office_e').each(function () {
            $(this).select2({
                height: '300%',
                width: '100%',
                dropdownParent: $(this).parent()
            });
        })

    });

</script>

@endsection
