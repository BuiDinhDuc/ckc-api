<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinhLuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binh_luans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('noidung')->nullable();
            $table->datetime('ngaytao')->nullable();
            $table->unsignedBigInteger('mabv');
            $table->unsignedBigInteger('matk');
            $table->boolean('trangthai')->default(1);
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
        Schema::dropIfExists('binh_luans');
    }
}
