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
            $table->string('masv',10);
            $table->string('tensv')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('diachi')->nullable();
            $table->string('sdt',10)->nullable();
            $table->string('cccd')->nullable();
            $table->string('matk',10)->nullable();
            $table->string('malh',10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();
            $table->primary('masv');
            $table->foreign('malh')->references('malh')->on('lop_hocs');
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
        Schema::dropIfExists('sinh_viens');
    }
}
