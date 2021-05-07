<?php

use App\ChuDe;
use Illuminate\Database\Seeder;

class ChuDeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChuDe::create(['tencd' => 'Chủ đề 01', 'malhp' => '1', 'trangthai' => 1]);
        ChuDe::create(['tencd' => 'Chủ đề 02', 'malhp' => '1', 'trangthai' => 1]);
        ChuDe::create(['tencd' => 'Chủ đề 03', 'malhp' => '1', 'trangthai' => 1]);
        ChuDe::create(['tencd' => 'Chủ đề 04', 'malhp' => '1', 'trangthai' => 1]);
        ChuDe::create(['tencd' => 'Chủ đề 05', 'malhp' => '1', 'trangthai' => 1]);
    }
}
