<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Device\Models\DeviceCategory::class, function (Faker $faker) {
    return [
        //
		'name'=>$faker->word,
		'code'=>$faker->unique()->randomNumber(),
    ];
});
