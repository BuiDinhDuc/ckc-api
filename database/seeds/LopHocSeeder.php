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
        $faker = Faker\Factory::create();

        $limit = 100;

        for ($i = 1; $i <= $limit; $i++) {
            DB::table('lop_hocs')->insert([
                'malh' => $i,
                'tenlop' => $faker->text('50'),
                'mabm' =>  $faker->numberBetween(1, 16),
                'trangthai' => 1,
            ]);
        }
    }
}
