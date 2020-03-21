<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BillingQueue;
use Faker\Generator as Faker;

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

$factory->define(BillingQueue::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName.$faker->unique(true)->numberBetween(0, 20000),
        'mobile_number' => $faker->phoneNumber,
        'amount_to_bill' => $faker->unique(true)->numberBetween(1000, 2000000000)
    ];
});
