<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuenMatKhausTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quen_mat_khaus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('matk')->nullable();
            $table->string('maxacnhan',6)->nullable();
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
        Schema::dropIfExists('quen_mat_khaus');
    }
}
