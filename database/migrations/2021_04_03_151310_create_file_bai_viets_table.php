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
            $table->string('mafile_bv', 10);
            $table->string('mafile', 10)->nullable();
            $table->string('mabv', 10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();

            $table->primary('mafile_bv');
            $table->foreign('mafile')->references('mafile')->on('files');
            $table->foreign('mabv')->references('mabv')->on('bai_viets');
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
