<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaiVietsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tieude')->nullable();
            $table->text('noidung')->nullable();
            $table->datetime('ngaytao')->nullable();
            $table->smallInteger('loaibv')->nullable();
            $table->unsignedBigInteger('matk')->nullable();
            $table->unsignedBigInteger('malhp')->nullable();
            $table->unsignedBigInteger('macd')->nullable();
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
        Schema::dropIfExists('bai_viets');
    }
}
