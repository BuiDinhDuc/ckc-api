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
        BoMon::create(['tenbm' => 'Cơ Khí Chế Tạo', 'makhoa' => '1']);
        BoMon::create(['tenbm' => 'Sửa Chữa Thiết Bị Cơ Khí - Hàn', 'makhoa' => '1']);
        BoMon::create(['tenbm' => 'Cơ Điện Tử', 'makhoa' => '1']);
        BoMon::create(['tenbm' => 'Ô Tô', 'makhoa' => '2']);
        BoMon::create(['tenbm' => 'Kỹ Thuật Cơ Sở', 'makhoa' => '2']);
        BoMon::create(['tenbm' => 'Tự Động Hóa', 'makhoa' => '3']);
        BoMon::create(['tenbm' => 'Điện Công Nghiệp', 'makhoa' => '3']);
        BoMon::create(['tenbm' => 'Điện Tử Công Nghiệp', 'makhoa' => '3']);
        BoMon::create(['tenbm' => 'Điện Tử Viễn Thông', 'makhoa' => '3']);
        BoMon::create(['tenbm' => 'Nhiệt Lạnh', 'makhoa' => '4']);
        BoMon::create(['tenbm' => 'Công Nghệ Phần Mềm', 'makhoa' => '5']);
        BoMon::create(['tenbm' => 'Phần Cứng & Mạng Máy Tính', 'makhoa' => '5']);
        BoMon::create(['tenbm' => 'Lý Luận Chính Trị - Pháp Luật', 'makhoa' => '6']);
        BoMon::create(['tenbm' => 'Giáo Dục Thể Chất - Quốc Phòng', 'makhoa' => '6']);
        BoMon::create(['tenbm' => 'Văn Hóa - Ngoại Ngữ', 'makhoa' => '6']);
        BoMon::create(['tenbm' => 'Kinh Tế', 'makhoa' => '7']);
    }
}
