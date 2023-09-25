<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyewaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_referensi');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('nama_penyewa');
            $table->string('no_telp');
            $table->string('jumlah');
            $table->date('dari');
            $table->date('sampai');
            $table->string('total');
            $table->enum('status', ['0','1','2','3']);
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
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
        Schema::dropIfExists('penyewaans');
    }
}
