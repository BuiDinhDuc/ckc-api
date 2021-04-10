<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->string('mafile', 10);
            $table->text('tenfile')->nullable();
            $table->datetime('ngaytao')->nullable();
            $table->string('duoifile');
            $table->integer('dungluong')->nullable();
            $table->boolean('trangthai')->default(1);

            $table->primary('mafile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
