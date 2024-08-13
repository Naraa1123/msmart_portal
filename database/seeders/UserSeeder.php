<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'bilguun@mcoding.mn',
            'school_id' => 'MS_ADMIN2023',
            'role_as' => '1',
            'password' => Hash::make('112352935'),
        ]);

        DB::table('user_details')->insert([
            'user_id' => 1,
            'firstname' => 'admin',
            'lastname' => 'admin',
            'gender' => 'male',
            'registration_number' => 'ADMIN',
            'status' => 'studying',
            'phone_number_1' => '75050144',
            'phone_number_2' => '75050144',
            'phone_number_3' => '75050144',
            'date_of_birth' => '2001-11-23',
            'admission_year' => '2023-09-23',
            'address' => 'Төв замын цагдаагийн зүүн талд Юнион бюлдинг С блок 12 давхар 1208 тоот'
        ]);

//        $faker = Faker::create();
//
//        foreach (range(1, 99) as $index) {
//            DB::table('users')->insert([
//                'school_id' => $faker->word,
//                'class_id' => $faker->randomElement([1, 2, 3, null]), // Replace with your actual class IDs
//                'email' => $faker->unique()->safeEmail,
//                'password' => bcrypt('password'), // You can change this default password
//                'role_as' => $faker->randomElement([3]),
//                'remember_token' => Str::random(10),
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//        }
    }

}
