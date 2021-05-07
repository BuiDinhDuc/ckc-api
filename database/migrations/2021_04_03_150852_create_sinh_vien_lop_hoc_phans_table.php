<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhVienLopHocPhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinh_vien_lop_hoc_phans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('masv')->nullable();
            $table->unsignedBigInteger('malhp')->nullable();
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
        Schema::dropIfExists('sinh_vien_lop_hoc_phans');
    }
}
