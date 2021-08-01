<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiangViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giang_viens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hogv')->nullable();
            $table->string('tengv')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->smallInteger('gioitinh')->nullable();
            $table->string('sdt', 10)->nullable();
            $table->string('cccd')->nullable();
            $table->unsignedBigInteger('matk')->nullable();
            $table->unsignedBigInteger('mabm')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->text('diachi')->nullable();
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
        Schema::dropIfExists('giang_viens');
    }
}
