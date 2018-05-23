<?php

use Illuminate\Database\Seeder;

class DeviceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		factory(\Modules\Device\Models\DeviceCategory::class)->create();
    }
}
