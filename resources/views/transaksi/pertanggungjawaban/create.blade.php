@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Create LPJ</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('user.index')}}">LPJ</a></div>
        <div class="breadcrumb-item"><a href="#">Create LPJ</a></div>
    </div>
</div>
<!-- @if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif -->

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
            <div class="card-header">
                <button class="btn btn-icon btn-outline-warning" onclick="window.history.back()"><i class="fa fa-arrow-circle-left"></i> Kembali</button> 
                </div>
                <div class="card-body">
                    @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endif
                    <form action="{{route('pertanggungjawaban.store')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">No Kasbon</label>
                            <div class="col-sm-10">
                                <select name="kasbon_id" id="kasbon_id" class="form-control select2">
                                   <option value="">-- Masukkan No Kasbon --</option>
                                    @foreach($cashbons as $casbon)
                                    <option value="{{$casbon->id}}">{{$casbon->no_transaksi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Tanggal LPJ</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" id="tanggal_lpj" name="tanggal_lpj">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Nilai</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="nominal_kasbon">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Nilai PertanggungJawaban</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="nominal" name="nominal">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Refund Dana</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="refund" name="refund">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Selisih</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="selisih" name="selisih">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create">Save
                                    changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <script type="text/javascript">
    $(document).ready(function () {
        $("#nominal_kasbon,#nominal,#refund,#selisih")
            .keyup(function () {
                var nominal_kasbon = $("#nominal_kasbon").val();
                var nominal = $("#nominal").val();
                var refund = $("#refund").val();
                var selisih =
                    parseInt(nominal_kasbon) - parseInt(nominal) - parseInt(refund);
                $("#selisih").val(selisih);
            });
    });

</script>
<!-- <script>
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

</script> -->

<script type="text/javascript">
    $('#kasbon_id').change(function () {

        if ($('#kasbon_id').val() != '') {
            var id = $('#kasbon_id').val();
            $.ajax({
                type: "GET",
                url: "{{url('ambil-no-kas')}}?id=" + id,
                success: function (res) {
                    console.log(res)
                    var nominal_kasbon = res.nominal_kasbon;
                    if (res) {


                        $("#nominal_kasbon").val(nominal_kasbon);


                    } else {
                        $("#nominal_kasbon").empty();

                    }
                }
            });
        }

    });

</script>
    @endsection
