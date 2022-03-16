<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghasilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // is_kategori
        // 0 = GYM
        // 1 = Produk

        Schema::create('penghasilans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto');
            $table->string('keterangan');
            $table->integer('is_kategori');
            $table->integer('harga');
            $table->date('tanggal');
            $table->time('waktu');
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
        Schema::dropIfExists('penghasilans');
    }
}
