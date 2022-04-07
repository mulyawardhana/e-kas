<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun_banks', function (Blueprint $table) {
            $table->id();
            $table->string('akun')->nullable();
            $table->bigInteger('rek_akun')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('branch_alias')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('no_coa')->nullable();
            $table->double('saldo_minimum')->nullable();
            $table->double('saldo')->nullable();
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
        Schema::dropIfExists('akun_banks');
    }
}
