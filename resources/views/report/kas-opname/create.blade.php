@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Cash Opname</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.create')}}">Create-Pemakaian-kas</a></div>
    </div>
</div>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <!-- <div class="card-header">
                    <a class="btn btn-success" href="{{route('pemakaian-kas.create')}}">
                        <i class="fas fa-plus-circle"></i> Tambah Master Klasifikasi
                    </a>
                </div> -->
                <div class=""></div>
                <div class="card-body">
                    @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endif
                    <form action="{{route('report.cashopname')}}" method="POST" >
                        @csrf
                        <form>
                        <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Pilih Akun Bank</label>
                                <div class="col-sm-10">
                                    <select name="akun_bank_id" id="akun_bank_id" class="form-control select2" required>

                                        @foreach($akunBanks as $akun)
                                        <option value="{{$akun->id}}">{{$akun->akun}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Tahun & Bulan</label>
                                <div class="col-sm-10">
                                    <input type="month" class="form-control" id="month_year" name="month_year" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="button">Submit</button>
                        </form>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- <script type="text/javascript">
    $(document).ready(function () {
        $("#bon_sementara,#kas_tunai,#bukti_belum_bayar,#grand_total,#pk_100k1, #pk_100k,#pk_50k1,#pk_50k,#pk_20k1,#pk_20k,#pk_10k1,#pk_10k,#pk_5k1,#pk_5k,#pk_2k1,#pk_2k,#pk_1k1,#pk_1k,#pl_10001,#pl_1000,#pl_5001,#pl_500,#pl_2001,#pl_200,#pl_1001,#pl_100")
            .keyup(function () {
                var pk_100k1 = $("#pk_100k1").val();
                var pk_100k = $("#pk_100k").val();
                var pk_50k1 = $("#pk_50k1").val();
                var pk_50k = $("#pk_50k").val();
                var pk_20k1 = $("#pk_20k1").val();
                var pk_20k = $("#pk_20k").val();
                var pk_10k1 = $("#pk_10k1").val();
                var pk_10k = $("#pk_10k").val();
                var pk_5k1 = $("#pk_5k1").val();
                var pk_5k = $("#pk_5k").val();
                var pk_2k1 = $("#pk_2k1").val();
                var pk_2k = $("#pk_2k").val();
                var pk_1k1 = $("#pk_1k1").val();
                var pk_1k = $("#pk_1k").val();
                var pl_10001 = $("#pl_10001").val();
                var pl_1000 = $("#pl_1000").val();
                var pl_5001 = $("#pl_5001").val();
                var pl_500 = $("#pl_500").val();
                var pl_2001 = $("#pl_2001").val();
                var pl_200 = $("#pl_200").val();
                var pl_1001 = $("#pl_1001").val();
                var pl_100 = $("#pl_100").val();

                var bon_sementara = $("#bon_sementara").val();
                // var kas_tunai = $("#kas_tunai").val();
                var bukti_belum_bayar = $("#bukti_belum_bayar").val();


                var total =
                    parseInt(pk_100k1) * parseInt(pk_100k) + parseInt(pk_50k1) * parseInt(pk_50k) +
                    parseInt(pk_20k1) * parseInt(pk_20k) + parseInt(pk_10k1) * parseInt(pk_10k) +
                    parseInt(pk_5k1) * parseInt(pk_5k) + parseInt(pk_2k1) * parseInt(pk_2k) +
                    parseInt(pk_1k1) * parseInt(pk_1k) + parseInt(pl_10001) * parseInt(pl_1000) +
                    parseInt(pl_5001) * parseInt(pl_500) + parseInt(pl_2001) * parseInt(pl_200) +
                    parseInt(pl_1001) * parseInt(pl_100);
                var kas_tunai = parseInt(total) + parseInt(bon_sementara);
                var grand_total = parseInt(kas_tunai) + parseInt(bukti_belum_bayar);
                $("#total").val(total);
                $("#bon_sementara").val(bon_sementara);
                $("#kas_tunai").val(kas_tunai);
                // $("#bukti_belum_bayar").val(bukti_belum_bayar);
                $("#grand_total").val(grand_total);
            });
    });

</script>
<script>
    $('#grand_total, #saldo_awal').bind('keypress', function () {
        if ($('#grand_total').val() == $('#saldo_awal').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else
            $('#message').html('Not Matching').css('color', 'red');
    });

</script> -->

<!-- <script type="text/javascript">
    $('#akun_bank_id').change(function () {

        if ($('#akun_bank_id').val() != '') {
            var id = $('#akun_bank_id').val();
            $.ajax({
                type: "GET",
                url: "{{url('getOut')}}/" + id,
                success: function (res) {
                    console.log(res)
                    var nominal = res.nominal;
                    if (res) {

                        console.log(nominal)
                        $("#bukti_belum_bayar").val(nominal);

                    } else {
                        $("#bukti_belum_bayar").empty();
                        $("#bukti_belum_bayar").empty();

                    }
                }
            });
        }
        if ($('#akun_bank_id').val() != '') {
            var id = $('#akun_bank_id').val();
            $.ajax({
                type: "GET",
                url: "{{url('getCashBons')}}/" + id,
                success: function (res) {
                    console.log(res)
                    var nominal = res.nominal;
                    if (res) {

                        console.log(nominal)
                        $("#bon_sementara").val(nominal);

                    } else {
                        $("#bon_sementara").empty();
                        $("#bon_sementara").empty();

                    }
                }
            });
        }
        if ($('#akun_bank_id').val() != '') {
            var id = $('#akun_bank_id').val();
            $.ajax({
                type: "GET",
                url: "{{url('getCash')}}/" + id,
                success: function (res) {
                    console.log(res)
                    var saldo = res.saldo;
                    if (res) {

                        console.log(saldo)
                        $("#saldo_awal").val(saldo);

                    } else {
                        $("#saldo_awal").empty();
                        $("#saldo_awal").empty();

                    }
                }
            });
        }
        if ($('#month_year').val() != '') {
            var id = $('#month_year').val();
            $.ajax({
                type: "GET",
                url: "{{url('getMonth')}}/" + id,
                success: function (res) {
                    console.log(res)
                    var saldo = res.saldo;
                    if (res) {

                        console.log(saldo)
                        $("#saldo_awal").val(saldo);

                    } else {
                        $("#saldo_awal").empty();
                        $("#saldo_awal").empty();

                    }
                }
            });
        }
    });

</script> -->

@endsection
