<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukSuratjalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_suratjalans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suratjalan_id');
            $table->unsignedBigInteger('barang_id');
            $table->string('harga');
            $table->string('jumlah');
            $table->string('total');
            $table->foreign('suratjalan_id')->references('id')->on('suratjalans')->onDelete('cascade');
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
        Schema::dropIfExists('produk_suratjalans');
    }
}
