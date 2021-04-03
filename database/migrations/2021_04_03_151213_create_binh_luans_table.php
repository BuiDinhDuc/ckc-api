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
            $table->string('mabl',10);
            $table->text('noidung')->nullable();
            $table->datetime('ngaytao')->nullable();
            
            $table->string('mabv',10);
            $table->string('matk',10);

            $table->primary('mabl');
            $table->foreign('mabv')->references('mabv')->on('bai_viets');
            $table->foreign('matk')->references('matk')->on('users');
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
