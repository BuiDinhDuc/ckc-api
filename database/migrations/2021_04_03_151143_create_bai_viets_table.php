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
            $table->string('mabv', 10);
            $table->string('tieude')->nullable();
            $table->text('noidung')->nullable();
            $table->datetime('ngaytao')->nullable();
            $table->smallInteger('loaibv')->nullable();

            $table->string('matk', 10)->nullable();
            $table->string('malhp', 10)->nullable();
            $table->string('macd', 10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();

            $table->primary('mabv');
            $table->foreign('malhp')->references('malhp')->on('lop_hoc_phans');
            $table->foreign('matk')->references('matk')->on('users');
            $table->foreign('macd')->references('macd')->on('chu_des');
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
