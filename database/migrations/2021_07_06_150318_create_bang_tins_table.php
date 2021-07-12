<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBangTinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bang_tins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('noidung');
            $table->unsignedBigInteger('mabv')->nullable();
            $table->unsignedBigInteger('magv')->nullable();
            $table->unsignedBigInteger('malhp')->nullable();
            $table->smallInteger('loaibangtin')->nullable();

            $table->datetime('ngaytao')->nullable();
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
        Schema::dropIfExists('bang_tins');
    }
}
