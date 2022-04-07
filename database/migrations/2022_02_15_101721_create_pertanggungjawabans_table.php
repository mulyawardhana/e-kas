<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertanggungjawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertanggungjawabans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasbon_id');
            $table->bigInteger('nominal');
            $table->bigInteger('refund');
            $table->bigInteger('selisih');
            $table->string('action');
            $table->string('status');
            $table->string('tanggal_lpj');
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
        Schema::dropIfExists('pertanggungjawabans');
    }
}
