<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('akun_bank_id')->nullable();
            $table->unsignedInteger('klasifikasi_id')->nullable();
            $table->string('tanggal_dikeluarkan')->nullable();
            $table->string('tanggal_nota')->nullable();
            $table->string('no_nota')->nullable();
            $table->string('no_transaksi')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->string('file')->nullable();
            $table->string('file1')->nullable();
            $table->string('file2')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('no_coa')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('kas');
    }
}
