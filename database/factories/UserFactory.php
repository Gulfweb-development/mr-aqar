<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company_name' => null,
        'company_phone' => null,
        'email' => $faker->unique()->safeEmail,
        'package_id' => null,
        'mobile' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
        'sms_verified' => 1,
        'verified' => rand(0,1),
        'verified_office' => rand(0,1),
        'image_profile' => $faker->randomElement(['/images/main/user2.jpg', '/images/main/user4.jpg', '/images/main/user5.jpg']),
        'licence' => null,
        'type' => 'member',
        'type_usage' => 'individual',
        'is_enable' => 1,
        'password' => '$2y$10$J7v9SLBptg3JsPLWgQsq7OjOTRyHlW7Ub.VfMPZd3vb5C76H3YiAi', // 12345678
        'remember_token' => null,
        'api_token' => null,
        'device_token' => null,
        'lang' => 'en',
        'sms_code' => null,
        'created_at' => '2020-04-15 09:29:32',
        'updated_at' => '2020-04-15 09:29:32',
        'last_activity' => '2020-04-15 09:29:32',
        'password_token' => null,
        'package_expire_at' => null,
        'deleted_at' => null,
    ];
});

$factory->state(App\User::class, 'company', function (Faker $faker) {
    return [
        'company_name' => $faker->name(),
        'company_phone' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
        'type_usage' => 'company',
    ];
});
