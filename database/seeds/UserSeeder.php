<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 50;

        for ($i = 1; $i <= $limit; $i++) {
            $i < 10 ? $i = '0' . $i : $i = $i;
            DB::table('users')->insert([
                'matk' => '03061810' . $i,
                'password' => Hash::make('123456789'),
                'email' =>  $faker->unique()->email,
                'trangthai' => 1,
            ]);
        }
    }
}
