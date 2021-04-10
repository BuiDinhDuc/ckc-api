<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLopHocPhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lop_hoc_phans', function (Blueprint $table) {
            $table->string('malhp', 10);
            $table->string('tenlhp')->nullable();
            $table->date('ngaytao')->nullable();
            $table->smallInteger('hocky')->nullable();
            $table->smallInteger('chinhsach')->nullable();
            $table->string('namhoc')->nullable();
            $table->string('magv', 10)->nullable();
            $table->string('malh', 10)->nullable();
            $table->string('mamh', 10)->nullable();
            $table->boolean('trangthai')->default(1);
            $table->timestamps();

            $table->primary('malhp');
            $table->foreign('malh')->references('malh')->on('lop_hocs');
            $table->foreign('magv')->references('magv')->on('giang_viens');
            $table->foreign('mamh')->references('mamh')->on('mon_hocs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lop_hoc_phans');
    }
}
