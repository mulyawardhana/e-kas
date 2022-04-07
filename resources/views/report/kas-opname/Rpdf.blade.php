@php
$k1  = $cashopnames->pk_100k * 100000;
$k2   = $cashopnames->pk_50k * 50000;
$k3   = $cashopnames->pk_20k * 20000;
$k4   = $cashopnames->pk_10k * 10000;
$k5    = $cashopnames->pk_5k * 5000;
$k6    = $cashopnames->pk_2k * 2000;
$k7    = $cashopnames->pk_1k * 1000;
$k8  = $cashopnames->pl_1000 * 1000;
$k9   = $cashopnames->pl_500 * 500;
$k10   = $cashopnames->pl_200 * 200;
$k11   = $cashopnames->pl_100 * 100;
$total = $k1 + $k2 + $k3 + $k4 + $k5 + $k6 + $k7 + $k8 + $k9 + $k10 + $k11;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        @media print {

            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
                float: left;
            }

            .col-md-1 {
                width: 8%;
            }

            .col-md-2 {
                width: 16%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-4 {
                width: 33%;
            }

            .col-md-5 {
                width: 42%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-7 {
                width: 58%;
            }

            .col-md-8 {
                width: 66%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-10 {
                width: 83%;
            }

            .col-md-11 {
                width: 92%;
            }

            .col-md-12 {
                width: 100%;
            }
        }

    </style>
</head>

<body style="font-size:11px;" onload="window.print()">
    <div class="container-fluid  m-1" style="font-size:10px;">
        <div class="row">
            <div class="col-md-8 border border-dark">
                <h5>JENIS KAS/DANA : KAS OPERASIONAL</h5>
            </div>
            <div class="col-md-4 border border-dark">
                <div class="row">
                    <div class="col-md-12 border border-dark">
                        <h5>TGL. PERHITUNGAN KAS</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 border border-dark">
                    <h5>{{$cashopnames->month_year}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <table class="table mt-2 table-sm">
            <thead>
                <tr class="text-center">
                    <th>Jenis Mata Uang</th>
                    <th>&emsp;</th>
                    <th>Uang Pecahan</th>
                    <th>&emsp;</th>
                    <th>Banyak Lembar/Logam</th>
                    <th>&emsp;</th>
                    <th>&emsp;</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1.Uang Kertas</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>100.000</td>
                    <td>{{$cashopnames->pk_100k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k1,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp.</td>
                    <td></td>
                    <td>50.000</td>
                    <td>{{$cashopnames->pk_50k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k2,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>20.000</td>
                    <td>{{$cashopnames->pk_20k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k3,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>10.000</td>
                    <td>{{$cashopnames->pk_10k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k4,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp.</td>
                    <td></td>
                    <td> 5.000</td>
                    <td>{{$cashopnames->pk_5k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k5,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp.</td>
                    <td></td>
                    <td> 2.000</td>
                    <td>{{$cashopnames->pk_2k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k6,0,',','.')}}</td>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>1.000</td>
                    <td>{{$cashopnames->pk_1k}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k7,0,',','.')}}</td>
                </tr>

                <tr>
                    <td><strong>2.Uang Logam</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>1.000</td>
                    <td>{{$cashopnames->pl_1000}}</td>
                    <td>Lembar</td>
                    <td>Rp.</td>
                    <td style="text-align: right;">{{number_format($k8,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>500</td>
                    <td>{{$cashopnames->pl_500}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k9,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp.</td>
                    <td></td>
                    <td>200</td>
                    <td>{{$cashopnames->pl_200}}</td>
                    <td>Lembar</td>
                    <td>Rp. </td>
                    <td style="text-align: right;">{{number_format($k10,0,',','.')}}</td>
                </tr>
                <tr class="text-center">
                    <td></td>
                    <td>Rp. </td>
                    <td></td>
                    <td>100</td>
                    <td>{{$cashopnames->pl_100}}</td>
                    <td>Lembar</td>
                    <td>Rp.</td>
                    <td style="text-align: right;">{{number_format($k11,0,',','.')}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center"><strong>Jumlah</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Rp.</td>
                    <td style="text-align: right;">{{number_format($total,0,',','.')}}</td>
                </tr>
                <tr>
                    <td><strong>3. Cek,Kas Bon</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>a.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">Rp. {{$cashopnames->bon_sementara}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>

                <tr>
                    <td></td>
                    <td class="text-center"><strong>Jumlah</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Rp.</td>
                    <td style="text-align: right;">1.553.100</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Total Uang Tunai di KAS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Rp.</td>
                    <td style="text-align: right;"> {{$cashopnames->cash_on_hand}}</td>

                </tr>
                <tr>
                    <td>Saldo Tetap Kas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Rp.</td>
                    <td style="text-align: right;"> 2.000.000</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Selisih Lebih Kurang</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Rp. </td>
                    <td style="text-align: right;">1.553.100</td>
                </tr>
                <tr>
                    <td>Bukti-Bukti yang belum di bukukkan</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>a. Kas Ops tgl 30 Des 2017</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">Rp. 1.553.100</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- <tr>
                    <td>b.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>c.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> -->
                <tr class="text-center">
                    <td></td>
                    <td><strong>Jumlah</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Rp.</td>
                    <td style="text-align: right;"> 1.553.100</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">Selisih</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&emsp;&emsp;&emsp;&emsp;Rp.</td>
                    <td style="text-align: right;">1.553.100</td>
                </tr>
            </tbody>
        </table>
        <p>Dengan ini saya menyatakan bahwa dana diatas kepunyaan
            <strong>{{$cashopnames->jenis->jenis_kas}}</strong> telah dihitung didepan saya oleh</p>
        <p>Saudara/i <strong>{{$cashopnames->pemeriksa->nama}}</strong> wakil dari
            <strong>{{$cashopnames->nama_pemegang_kas}}</strong> pada tanggal
            <strong>{{$cashopnames->tanggal_cashopname}}</strong> dari</p>
        <p>jam <strong>{{$cashopnames->start_jam}}</strong> sampai jam <strong>{{$cashopnames->end_jam}}</strong> dan telah dikembalikan kepada saya dalam keadaan seperti diberikan semula.
            Tidak ada dana lain yang dipercayakan</p>
        <p>pada saya yang belum saya beritahukan (lihat dibawah).</p>
        <div class="row">
            <div class="col-md-6">Pemeriksa,</div>
            <div class="col-md-6" style="text-align:right;">Pemegang Kas,</div>
        </div><br><br><br>
        <div class="row">
            <div class="col-md-6"><u>{{$cashopnames->pemeriksa->nama}}</u></div>
            <div class="col-md-6" style="text-align:right;"><u>{{$cashopnames->nama_pemegang_kas}}</u></div>
        </div>
        <div class="row">
            <div class="col-md-6">KEPALA CABANG</div>
            <div class="col-md-6" style="text-align:right;">KASIR</div>
        </div>
    </div>
    <!-- <div class="row ">
        <div class="col-md-3">
            <p>1. Uang Kertas</p>
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
    </div>
    <div class="row ">
        <div class="col-md-3">

        </div>
        <div class="col-md-3 text-center">
            <p>Rp 100.000</p>
            <p>Rp 50.000</p>
            <p>Rp 20.000</p>
            <p>Rp 10.000</p>
            <p>Rp 5.000</p>
            <p>Rp 2.000</p>
            <p>Rp 1.000</p>
        </div>
        <div class="col-md-3">
            1
            <hr>1
            <hr>2
        </div>
        <div class="col-md-3 text-center">
            <p>Rp 100.000</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p>Rp 1.000</p>
        </div>

    </div>
    <div class="row ">
        <div class="col-md-3">
            <p>1. Uang Logam</p>
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
    </div>
    <div class="row ">
        <div class="col-md-3">
        </div>
        <div class="col-md-3 text-center">
            <p>Rp 10.000</p>
            <p>Rp 500</p>
            <p>Rp 200</p>
            <p>Rp 100</p>
            <p>Jumlah</p>
        </div>
        <div class="col-md-3">
            1
            <hr>1
            <hr>2
        </div>
        <div class="col-md-3 text-center">
            <p>Rp 100.000</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p>Rp. 1.000</p>
            <p>Rp. 446.900</p>
        </div>

    </div> -->
</body>

</html>
