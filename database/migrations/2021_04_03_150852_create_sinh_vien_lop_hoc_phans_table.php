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
            $table->string('masv_lhp', 10);
            $table->string('masv', 10)->nullable();
            $table->string('malhp', 10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();

            $table->primary('masv_lhp');
            $table->foreign('malhp')->references('malhp')->on('lop_hoc_phans');
            $table->foreign('masv')->references('masv')->on('sinh_viens');
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
