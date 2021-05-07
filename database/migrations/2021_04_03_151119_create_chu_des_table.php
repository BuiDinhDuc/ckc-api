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
            $table->bigIncrements('id');
            $table->string('tencd')->nullable();
            $table->integer('thutu')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->unsignedBigInteger('malhp')->nullable();
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
        Schema::dropIfExists('chu_des');
    }
}
