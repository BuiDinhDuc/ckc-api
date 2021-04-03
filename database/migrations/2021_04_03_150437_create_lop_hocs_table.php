<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLopHocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lop_hocs', function (Blueprint $table) {
            $table->string('malh',10);
            $table->string('tenlop')->nullable();
            $table->date('ngaytao')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->string('mabm',10)->nullable();
            $table->timestamps();
            $table->primary('malh');
            $table->foreign('mabm')->references('mabm')->on('bo_mons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lop_hocs');
    }
}
