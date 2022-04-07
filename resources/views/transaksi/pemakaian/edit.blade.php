@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Form Edit Pemakaian Kas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
        <div class="breadcrumb-item"><a href="#">Edit-Pemakaian-kas</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
            <div class="card-header">
                @can('pemakaian-list')
                <button class="btn btn-icon btn-outline-warning" onclick="window.history.back()"><i class="fa fa-arrow-circle-left"></i> Kembali</button> 
                @endcan    
            </div>
                <div class="card-body">
                    <form action="{{route('pemakaian-kas.update', $kas->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="staticEmail">Akun Bank <span class="text-danger">*</span></label>
                                    <select name="akun_bank_id" id="" class="form-control select2">
                                        @if(Auth::user()->type_user == 1)
                                        @foreach($akunBanks as $a)
                                        
                                        <option @if($kas->akun_bank_id == $a->id)selected @endif  value="{{$a->id}}">{{$a->akun}}</option>
                                      
                                        @endforeach
                                        @else 
                                        @foreach($akunBanks as $a)
                                         @foreach($a->akunBank as $b)
                                        <option @if($kas->akun_bank_id == $b->id)selected @endif value="{{$b->id}}">{{$b->akun}}</option>
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
                                    <label for="staticEmail">Tanggal dikeluarkan*</label>
                                    <input type="date" class="form-control" id="tanggal_dikeluarkan"
                                        name="tanggal_dikeluarkan" value="{{$kas->tanggal_dikeluarkan}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="nama_penerima">Nama Penerima*</label>
                                    <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="{{$kas->nama_penerima}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="no_nota">No Nota*</label>
                                    <input type="text" class="form-control" id="no_nota" name="no_nota" value="{{$kas->no_nota}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="no_akun">Akun Transaksi*</label>
                                    <select name="klasifikasi_id" id="id_klasifikasi" class="form-control select2">
                                        <option value="">-- Pilih Akun Transaksi --</option>
                                        @foreach($klasifikasi as $k)
                                        <option  @if($kas->klasifikasi_id == $k->id) selected @endif value="{{$k->id}}">{{$k->sub_akun_transaksi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="no_akun_induk">Nomor Akun</label>
                                    <input type="text" class="form-control" readonly id="no_akun_induk" value="{{$kas->klasifikasi->no_akun_induk}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="nama_akun_induk">Nama Akun</label>
                                    <input type="text" class="form-control" readonly id="nama_akun_induk" value="{{$kas->klasifikasi->nama_akun_induk}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="sub_akun_induk">Sub Akun Induk</label>
                                    <input type="text" class="form-control" readonly id="sub_akun_induk" value="{{$kas->klasifikasi->sub_akun_induk}}" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="keterangan">Keterangan Biaya*</label>
                            <textarea id="" cols="30" rows="10" name="keterangan" class="form-control" >{{$kas->keterangan}}</textarea>
                        </div>
                        <div class="form-group ">
                            <label for="nominal">Nominal Biaya*</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" value="{{ltrim($kas->nominal, '-')}}">
                        </div>
                        <div class="form-group ">
                            <label for="tanggal_nota">Tanggal Nota*</label>
                            <input type="date" class="form-control" id="tanggal_nota" name="tanggal_nota" value="{{$kas->tanggal_nota}}">
                        </div>
                        <!-- <div class="form-group ">
                            <label for="file">Attachemnt*</label>
                            <input type="file" class="form-control" id="file" name="file" value="{{$kas->file}}">
                            @error('file')
                                <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                            @enderror
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group " id="customFields">
                                    <label for="file">Attachemnt <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    @error('file')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                    <!-- <a href="javascript:void(0);" class="addCF btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i></a> -->
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group " id="customFields">
                                    <label for="file1">Attachemnt 2 <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file1" name="file1">
                                    @error('file1')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                    <a href="javascript:void(0);" class="addCF btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group " id="customFields">
                                    <label for="file2">Attachemnt 3<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file2" name="file2">
                                    @error('file2')
                                    <div class="text-danger"><strong><i>{{ $message }}</i></strong></div>
                                    @enderror
                                    <a href="javascript:void(0);" class="addCF btn btn-sm btn-success mt-3"><i class="fas fa-plus"></i></a>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-block" id="saveBtn" value="create">Save
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
