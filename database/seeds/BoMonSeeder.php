<?php

use Illuminate\Database\Seeder;
use App\BoMon;

class BoMonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoMon::create(['mabm' => '01', 'tenbm' => 'Cơ Khí Chế Tạo', 'makhoa' => '01']);
        BoMon::create(['mabm' => '02', 'tenbm' => 'Sửa Chữa Thiết Bị Cơ Khí - Hàn', 'makhoa' => '01']);
        BoMon::create(['mabm' => '03', 'tenbm' => 'Cơ Điện Tử', 'makhoa' => '01']);
        BoMon::create(['mabm' => '04', 'tenbm' => 'Ô Tô', 'makhoa' => '02']);
        BoMon::create(['mabm' => '05', 'tenbm' => 'Kỹ Thuật Cơ Sở', 'makhoa' => '02']);
        BoMon::create(['mabm' => '06', 'tenbm' => 'Tự Động Hóa', 'makhoa' => '03']);
        BoMon::create(['mabm' => '07', 'tenbm' => 'Điện Công Nghiệp', 'makhoa' => '03']);
        BoMon::create(['mabm' => '08', 'tenbm' => 'Điện Tử Công Nghiệp', 'makhoa' => '03']);
        BoMon::create(['mabm' => '09', 'tenbm' => 'Điện Tử Viễn Thông', 'makhoa' => '03']);
        BoMon::create(['mabm' => '10', 'tenbm' => 'Nhiệt Lạnh', 'makhoa' => '04']);
        BoMon::create(['mabm' => '11', 'tenbm' => 'Công Nghệ Phần Mềm', 'makhoa' => '05']);
        BoMon::create(['mabm' => '12', 'tenbm' => 'Phần Cứng & Mạng Máy Tính', 'makhoa' => '05']);
        BoMon::create(['mabm' => '13', 'tenbm' => 'Lý Luận Chính Trị - Pháp Luật', 'makhoa' => '06']);
        BoMon::create(['mabm' => '14', 'tenbm' => 'Giáo Dục Thể Chất - Quốc Phòng', 'makhoa' => '06']);
        BoMon::create(['mabm' => '15', 'tenbm' => 'Văn Hóa - Ngoại Ngữ', 'makhoa' => '06']);
        BoMon::create(['mabm' => '16', 'tenbm' => 'Kinh Tế', 'makhoa' => '07']);
    }
}
