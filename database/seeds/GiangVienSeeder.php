<?php

use Illuminate\Database\Seeder;

class GiangVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('giang_viens')->insert(['hogv' => "Lê Viết Hoàng", 'tensv' => "Nguyên",  'gioitinh' => 1, 'sdt' => "0123456789", 'cccd' => '123456789012', 'matk' => 1, 'mabm' => 3, 'province_id' => 1, 'district_id' => 1, 'ward_id' => 1, 'trangthai' => 1]);

    }
}
