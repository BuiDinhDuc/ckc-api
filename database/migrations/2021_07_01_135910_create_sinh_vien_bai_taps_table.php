<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhVienBaiTapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinh_vien_bai_taps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mssv')->nullable();
            $table->unsignedBigInteger('mabv')->nullable();
            $table->smallInteger('trangthai')->nullable();
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
        Schema::dropIfExists('sinh_vien_bai_taps');
    }
}
