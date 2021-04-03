<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChuDesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chu_des', function (Blueprint $table) {
            $table->string('macd',10);
            $table->string('tencd')->nullable();
            $table->integer('thutu')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->string('malhp',10)->nullable();

            $table->primary('macd');
            $table->foreign('malhp')->references('malhp')->on('lop_hoc_phans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chu_des');
    }
}
