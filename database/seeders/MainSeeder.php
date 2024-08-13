<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Week;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('web_setting')->insert([
            'id' => 'd03a7f43-f1e3-47b0-8a61-21e79df08c7f',
            'web_name' => 'MCoding',
            'address' => 'Төв замын цагдаагийн зүүн талд Юнион бюлдинг С блок 12 давхар 1208 тоот',
            'web_logo' => 'uploads/web_data_setting/logo.png',
            'email' => 'info@mcoding.mn',
            'phone_number' => 75050144,

            'google_map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1544.9504937362256!2d106.92953971075154!3d47.90886126595317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5d96923174c0fe0f%3A0x706fdd24e878373c!2sUnion%20Building!5e0!3m2!1sen!2smn!4v1698916528271!5m2!1sen!2smn',
            'facebook_link' => 'https://www.facebook.com/Msmartacademy',
            'instagram_link' => 'https://www.instagram.com/m_coding_academy/',
            'youtube_link' => 'https://youtube.com/@m-smart-academy?si=9E4tXH-XlfO9rLqX'
        ]);

        $dataDep = [
            [
                'name' => 'Програм хангамж 1 жил',
                'abbreviation' => 'SO',
            ],
            [
                'name' => 'Програм хангамж 6 сар',
                'abbreviation' => 'SS',
            ],
            [
                'name' => 'График Дизайн 1 жил',
                'abbreviation' => 'GO',
            ],
            [
                'name' => 'График Дизайн 6 сар',
                'abbreviation' => 'GF',
            ],
            [
                'name' => 'Интерьер Дизайн 1 жил',
                'abbreviation' => 'IO',
            ],
            [
                'name' => 'Интерьер Дизайн 5 сар',
                'abbreviation' => 'IF',
            ],
            [
                'name' => 'Хүүхдийн Анги 3 сар',
                'abbreviation' => 'KT',
            ],
            [
                'name' => 'Гурвалсан 1 жил',
                'abbreviation' => 'TO'
            ]
        ];

        $dataWeek = [
            [
                'name' => 'Monday',
            ],
            [
                'name' => 'Tuesday',
            ],
            [
                'name' => 'Wednesday',
            ],
            [
                'name' => 'Thursday',
            ],
            [
                'name' => 'Friday',
            ],
            [
                'name' => 'Saturday',
            ],
            [
                'name' => 'Sunday',
            ],

        ];

        Department::insert($dataDep);

        Week::insert($dataWeek);


    }


}
