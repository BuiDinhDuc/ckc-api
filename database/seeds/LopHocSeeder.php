<?php

use Illuminate\Database\Seeder;

class LopHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lop_hocs')->insert(['tenlop' => "CĐ TH 18 PMA", 'mabm' =>  11, 'trangthai' => 1,]);
        DB::table('lop_hocs')->insert(['tenlop' => "CĐ TH 18 PMB", 'mabm' =>  11, 'trangthai' => 1,]);
        DB::table('lop_hocs')->insert(['tenlop' => "CĐ TH 18 PMC", 'mabm' =>  11, 'trangthai' => 1,]);
        DB::table('lop_hocs')->insert(['tenlop' => "CĐ TH 18 MMT", 'mabm' =>  11, 'trangthai' => 1,]);
    }
}
