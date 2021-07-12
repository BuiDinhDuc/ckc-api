<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVanBanIntoBaiLamSinhVien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bai_lam_sinh_viens', function (Blueprint $table) {
            $table->text('van_ban')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bai_lam_sinh_viens', function (Blueprint $table) {
            $table->dropColumn('van_ban');
        });
    }
}
