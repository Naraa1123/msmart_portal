<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'class_id' => 1,
            'email' => 'student1@gmail.com',
            'school_id' => 'SO23120101',
            'role_as' => '3',
            'password' => Hash::make('112352935'),
        ]);

        DB::table('user_details')->insert([
            'user_id' => 2,
            'firstname' => 'student1',
            'lastname' => 'student1',
            'gender' => 'male',
            'registration_number' => 'ЧЕ99119901',
            'status' => 'studying',
            'phone_number_1' => '98765432',
            'phone_number_2' => '98765432',
            'phone_number_3' => '98765432',
            'date_of_birth' => '2002-11-23',
            'admission_year' => '2023-12-25',
            'guardian_name' => 'test',
            'guardian_phone_number' => '77777777',
            'image' => 'admin.jpg',
            'address' => 'test address'
        ]);

        DB::table('users')->insert([
            'class_id' => 1,
            'email' => 'student2@gmail.com',
            'school_id' => 'SO23120102',
            'role_as' => '3',
            'password' => Hash::make('112352935'),
        ]);

        DB::table('user_details')->insert([
            'user_id' => 3,
            'firstname' => 'student2',
            'lastname' => 'student2',
            'gender' => 'male',
            'registration_number' => 'ЧЕ99119902',
            'status' => 'studying',
            'phone_number_1' => '98765432',
            'phone_number_2' => '98765432',
            'phone_number_3' => '98765432',
            'date_of_birth' => '2002-11-23',
            'admission_year' => '2023-12-25',
            'guardian_name' => 'test',
            'guardian_phone_number' => '77777777',
            'image' => 'admin.jpg',
            'address' => 'test address'
        ]);


        DB::table('users')->insert([
            'class_id' => 1,
            'email' => 'student3@gmail.com',
            'school_id' => 'SO23120103',
            'role_as' => '3',
            'password' => Hash::make('112352935'),
        ]);

        DB::table('user_details')->insert([
            'user_id' => 4,
            'firstname' => 'student2',
            'lastname' => 'student2',
            'gender' => 'male',
            'registration_number' => 'ЧЕ99119903',
            'status' => 'studying',
            'phone_number_1' => '98765432',
            'phone_number_2' => '98765432',
            'phone_number_3' => '98765432',
            'date_of_birth' => '2002-11-23',
            'admission_year' => '2023-12-25',
            'guardian_name' => 'test',
            'guardian_phone_number' => '77777777',
            'image' => 'admin.jpg',
            'address' => 'test address'
        ]);
    }
}
