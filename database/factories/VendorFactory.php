<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Device\Models\Vendor::class, function (Faker $faker) {
    return [
        //
		'name'=>$faker->company,
		'code'=>$faker->unique()->randomNumber(),
    ];
});
