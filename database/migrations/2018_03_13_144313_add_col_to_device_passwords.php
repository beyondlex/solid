<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToDevicePasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_passwords', function (Blueprint $table) {
            //
			$table->string('status', 20)->after('e_time')->comment('设备状态')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_passwords', function (Blueprint $table) {
            //
			$table->dropColumn('status');
        });
    }
}
