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
            $table->string('magv', 10);
            $table->string('tengv')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('diachi')->nullable();
            $table->string('sdt', 10)->nullable();
            $table->string('cccd')->nullable();
            $table->string('matk', 10)->nullable();
            $table->string('mabm', 10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->timestamps();

            $table->primary('magv');
            $table->foreign('mabm')->references('mabm')->on('bo_mons');
            $table->foreign('matk')->references('matk')->on('users');
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
        Schema::dropIfExists('giang_viens');
    }
}
