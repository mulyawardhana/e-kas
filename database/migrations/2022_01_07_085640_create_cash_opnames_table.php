<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('no_cashopname')->nullable();
            $table->string('month_year')->nullable();
            $table->double('pk_100k')->nullable();
            $table->double('pk_50k')->nullable();
            $table->double('pk_20k')->nullable();
            $table->double('pk_10k')->nullable();
            $table->double('pk_5k')->nullable();
            $table->double('pk_2k')->nullable();
            $table->double('pk_1k')->nullable();
            $table->double('pl_1000')->nullable();
            $table->double('pl_500')->nullable();
            $table->double('pl_200')->nullable();
            $table->double('pl_100')->nullable();
            $table->double('bon_sementara')->nullable();
            $table->double('cash_on_hand')->nullable();
            $table->double('total_kas_tunai')->nullable();
            $table->double('belum_dibayarkan')->nullable();
            $table->double('grand_total')->nullable();
            $table->double('saldo_awal')->nullable();
            $table->bigInteger('jenis_kas_id')->nullable();
            $table->bigInteger('pemeriksa_kas_id')->nullable();
            $table->bigInteger('akun_bank_id')->nullable();
            $table->string('divisi')->nullable();
            $table->string('nama_pemegang_kas')->nullable();
            $table->string('tanggal_cashopname')->nullable();
            $table->string('start_jam')->nullable();
            $table->string('end_jam')->nullable();
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
        Schema::dropIfExists('cash_opnames');
    }
}
