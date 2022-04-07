@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Input Pemakaian Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.create')}}">Create-Pemakaian-kas</a></div>
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
                    <form action="{{route('pemakaian-kas.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="staticEmail">Akun Bank <span class="text-danger">*</span></label>
                                    <select name="akun_bank_id" id="" class="form-control select2">
                                        @if(Auth::user()->type_user == 1)
                                        <option value="">-- Pilih Akun Banks --</option>
                                        @foreach($akunBanks as $a)

                                        <option value="{{$a->id}}">{{$a->akun}}</option>

                                        @endforeach
                                        @else
                                        @foreach($akunBanks as $a)
                                        @foreach($a->akunBank as $b)
                                        <option value="{{$b->id}}">{{$b->akun}}</option>
                                        @endforeach
                                        @endforeach

                                        @endif
                                    </select>
                                    @error('tanggal_dikeluarkan')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="staticEmail">Tanggal dikeluarkan <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_dikeluarkan"
                                        name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan') }}">
                                    @error('tanggal_dikeluarkan')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="nama_penerima">Nama Penerima Dana<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_penerima" name="nama_penerima"
                                        value="{{ old('nama_penerima') }}">
                                    @error('nama_penerima')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="no_nota">No Nota <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_nota" name="no_nota"
                                        value="{{ old('no_nota') }}">
                                    @error('no_nota')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="no_akun">Akun Transaksi <span class="text-danger">*</span></label>
                                    <select name="klasifikasi_id" id="id_klasifikasi" class="form-control select2">
                                        <option value="">-- Pilih Akun Transaksi --</option>
                                        @foreach($klasifikasi as $k)
                                        <option value="{{$k->id}}">{{$k->sub_akun_transaksi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('klasifikasi_id')
                                <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="no_akun_induk">No Akun Induk</label>
                                    <input type="text" class="form-control" readonly id="no_akun_induk">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="nama_akun_induk">Nama Akun</label>
                                    <input type="text" class="form-control" readonly id="nama_akun_induk">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="sub_akun_induk">Sub Akun Induk</label>
                                    <input type="text" class="form-control" readonly id="sub_akun_induk">
                                </div>
                            </div>
                            <!-- <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="nama_akun_induk">Nama Akun</label>
                                    <input type="text" class="form-control" readonly id="nama_akun_induk">
                                </div>
                            </div> -->
                        </div>
                        <div class="form-group ">
                            <label for="keterangan">Keterangan Biaya <span class="text-danger">*</span></label>
                            <textarea id="" cols="30" rows="10" name="keterangan"
                                class="form-control">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="nominal">Nominal Biaya <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nominal" name="nominal"
                                value="{{ old('nominal') }}">
                            <i class="text-danger">* Nilai per bukti pembayaran maks Rp. 500.000,-</i>
                            @error('nominal')
                            <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="tanggal_nota">Tanggal Nota <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_nota" name="tanggal_nota"
                                value="{{ old('tanggal_nota') }}">
                            @error('tanggal_nota')
                            <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group " id="customFields">
                                    <label for="file">Attachemnt <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    <i class="text-danger">* attachment note <strong>jpg | png | pdf</strong></i>
                                    @error('file')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                    <!-- <a href="javascript:void(0);" class="addCF btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i></a> -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group " id="customFields">
                                    <label for="file1">Attachemnt <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file1" name="file1">
                                    @error('file1')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                  
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group " id="customFields">
                                    <label for="file2">Attachemnt <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file2" name="file2">
                                    @error('file2')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                  
                                </div>
                            </div>
                        </div>



                        <div class="form-group ">
                            <button type="submit" class="btn btn-danger btn-block" id="saveBtn" value="create">Save
                                changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

</div>
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
<script>
    $(document).ready(function () {
        $(".addCF").click(function () {
            $("#customFields").append(
                ' <div class="row mt-2"><label for="staticEmail" class="col-sm-2 col-form-label"><a href="javascript:void(0);" class="remCF btn btn-danger btn-sm"><i class="fas fa-times"></i></a></label><div  id="customFields"><input type="file" class="code form-control" id="customFieldName" name="file[]" multiple  placeholder="Input Email" /> &nbsp;</div></div>'
            );
        });
        $("#customFields").on('click', '.remCF', function () {
            $(this).parent().parent().remove();
        });
    });

</script>
<script type="text/javascript">
    $('#id_klasifikasi').change(function () {

        if ($('#id_klasifikasi').val() != '') {
            var id = $('#id_klasifikasi').val();
            $.ajax({
                type: "GET",
                url: "{{url('ambil')}}?id=" + id,
                success: function (res) {
                    console.log(res)
                    var no_akun_induk = res.no_akun_induk;
                    var nama_akun_induk = res.nama_akun_induk;
                    var sub_akun_induk = res.sub_akun_induk;
                    if (res) {


                        $("#no_akun_induk").val(no_akun_induk);
                        $("#nama_akun_induk").val(nama_akun_induk);
                        $("#sub_akun_induk").val(sub_akun_induk);


                    } else {
                        $("#no_akun_induk").empty();
                        $("#sub_akun_induk").empty();

                    }
                }
            });
        }

    });

</script>
@endsection
