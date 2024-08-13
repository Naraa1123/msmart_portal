<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\UserDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

it('return a successful response', function () {
    Department::create([
        'name' => 'Department 1',
        'status' => 0,
        'abbreviation' => 'SO',
    ]);

    $user=User::factory()->create();
    UserDetail::create([
        'user_id' => $user->id,
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'gender' => 'male',
        'registration_number'=>'Admin',
        'status' => 'studying',
        'phone_number_1'=>'0123456789',
        'phone_number_2'=>'0123456789',
        'phone_number_3'=>'0123456789',
        'date_of_birth'=>'1990-01-01',
        'admission_year'=>'2020-01-01',
        'address'=>'Address',
        'has_diploma'=>'not_received',
        'made_contract'=>'no'
    ]);

    $response = $this->actingAs($user)->get(route('admin.department-create'));

    $response->assertStatus(200);
});
