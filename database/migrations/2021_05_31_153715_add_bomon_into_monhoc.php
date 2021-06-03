<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBomonIntoMonhoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mon_hocs', function (Blueprint $table) {
            $table->unsignedBigInteger('mabm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mon_hocs', function (Blueprint $table) {
            $table->dropColumn('mabm');
        });
    }
}
