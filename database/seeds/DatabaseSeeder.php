<?php

use App\ChuDe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KhoaSeeder::class);
        $this->call(BoMonSeeder::class);
        $this->call(LopHocSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SinhVienSeeder::class);
        $this->call(ChuDeSeeder::class);
    }
}
