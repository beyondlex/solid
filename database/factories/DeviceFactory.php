<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Device\Models\Device::class, function (Faker $faker) {
    return [
        //
		'name'=>$faker->word,
		'client_id'=>1,
		'origin_id'=>$faker->text(6),
		'vendor_id'=>(\Modules\Device\Models\Vendor::inRandomOrder()->first())->id,
		'cate_id'=>(\Modules\Device\Models\DeviceCategory::inRandomOrder()->first())->id,
    ];
});
