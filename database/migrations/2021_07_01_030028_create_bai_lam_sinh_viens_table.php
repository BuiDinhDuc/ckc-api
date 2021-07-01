<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaiLamSinhViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bai_lam_sinh_viens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('link')->nullable();
            $table->unsignedBigInteger('mafile')->nullable();
            $table->unsignedBigInteger('mabv');
            $table->unsignedBigInteger('mssv');
            $table->boolean('trangthai')->default(2);
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
        Schema::dropIfExists('bai_lam_sinh_viens');
    }
}
