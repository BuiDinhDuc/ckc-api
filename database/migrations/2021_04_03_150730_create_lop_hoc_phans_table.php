<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLopHocPhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lop_hoc_phans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenlhp')->nullable();
            $table->date('ngaytao')->nullable();
            $table->smallInteger('hocky')->nullable();
            $table->smallInteger('chinhsach')->nullable();
            $table->integer('namhoc')->nullable();
            $table->unsignedBigInteger('magv')->nullable();
            $table->unsignedBigInteger('malh')->nullable();
            $table->unsignedBigInteger('mamh')->nullable();
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
        Schema::dropIfExists('lop_hoc_phans');
    }
}
