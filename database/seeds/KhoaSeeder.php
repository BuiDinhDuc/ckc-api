<?php

use Illuminate\Database\Seeder;
use App\Khoa;

class KhoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Khoa::create(['makhoa' => '01', 'tenkhoa' => 'Khoa Cơ Khí']);
        Khoa::create(['makhoa' => '02', 'tenkhoa' => 'Khoa Cơ Khí Động Lực']);
        Khoa::create(['makhoa' => '03', 'tenkhoa' => 'Khoa Điện - Điện Tử']);
        Khoa::create(['makhoa' => '04', 'tenkhoa' => 'Khoa Công Nghệ Nhiệt - Lạnh']);
        Khoa::create(['makhoa' => '05', 'tenkhoa' => 'Khoa Công Nghệ Thông Tin']);
        Khoa::create(['makhoa' => '06', 'tenkhoa' => 'Khoa Giáo Dục Đại Cương']);
        Khoa::create(['makhoa' => '07', 'tenkhoa' => 'Khoa Kinh Tế']);
    }
}
