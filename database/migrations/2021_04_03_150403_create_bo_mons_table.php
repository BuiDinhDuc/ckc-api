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
            $table->string('mabm', 10);
            $table->string('tenbm')->nullable();
            $table->date('ngaylap')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->string('makhoa', 10)->nullable();
            $table->timestamps();

            $table->primary('mabm');
            $table->foreign('makhoa')->references('makhoa')->on('khoas');
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
