<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbons', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tanggal_pengajuan')->nullable();
            $table->unsignedInteger('akun_bank_id')->nullable();
            $table->unsignedInteger('klasifikasi_id')->nullable();
            $table->string('no_transaksi')->nullable();
            $table->double('nominal');
            $table->string('file');
            $table->string('keterangan');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('cashbons');
    }
}
