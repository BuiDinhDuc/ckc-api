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
        Khoa::create(['tenkhoa' => 'Khoa Cơ Khí']);
        Khoa::create(['tenkhoa' => 'Khoa Cơ Khí Động Lực']);
        Khoa::create(['tenkhoa' => 'Khoa Điện - Điện Tử']);
        Khoa::create(['tenkhoa' => 'Khoa Công Nghệ Nhiệt - Lạnh']);
        Khoa::create(['tenkhoa' => 'Khoa Công Nghệ Thông Tin']);
        Khoa::create(['tenkhoa' => 'Khoa Giáo Dục Đại Cương']);
        Khoa::create(['tenkhoa' => 'Khoa Kinh Tế']);
    }
}
