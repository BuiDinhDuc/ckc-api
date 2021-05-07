<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonHocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon_hocs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenmh')->nullable();
            $table->date('tinchi')->nullable();
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
        Schema::dropIfExists('mon_hocs');
    }
}
