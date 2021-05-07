<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileBaiVietsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_bai_viets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mafile')->nullable();
            $table->unsignedBigInteger('mabv')->nullable();
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
        Schema::dropIfExists('file_bai_viets');
    }
}
