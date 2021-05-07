<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoMonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bo_mons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenbm')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->unsignedBigInteger('makhoa')->nullable();
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
        Schema::dropIfExists('bo_mons');
    }
}
