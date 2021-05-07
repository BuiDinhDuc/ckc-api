<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hosv')->nullable();
            $table->string('tensv')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->smallInteger('gioitinh')->nullable();
            $table->string('sdt', 10)->nullable();
            $table->string('cccd')->nullable();
            $table->unsignedBigInteger('matk')->nullable();
            $table->unsignedBigInteger('malh')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('ward_id')->references('id')->on('wards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinh_viens');
    }
}
