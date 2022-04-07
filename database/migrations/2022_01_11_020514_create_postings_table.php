<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('klasifikasi_id')->nullable();
            $table->string('tanggal_dikeluarkan')->nullable();
            $table->string('tanggal_nota')->nullable();
            $table->string('no_posting')->nullable();
            $table->string('no_nota')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->string('file')->nullable();
            $table->string('deskripsi')->nullable();
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
        Schema::dropIfExists('postings');
    }
}
