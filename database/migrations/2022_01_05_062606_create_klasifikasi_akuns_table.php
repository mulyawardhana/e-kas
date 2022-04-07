<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlasifikasiAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klasifikasi_akuns', function (Blueprint $table) {
            $table->id();
            $table->string('no_akun_induk');
            $table->string('nama_akun_induk');
            $table->string('sub_akun_induk');
            $table->string('jenis_transaksi')->nullable();
            $table->string('sub_akun_transaksi')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klasifikasi_akuns');
    }
}
