<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceReqLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_req_logs', function (Blueprint $table) {
            $table->string('id', 36);
			$table->primary('id');
            $table->string('device_category_id', 36)->default('');
            $table->string('device_id', 36)->default('');
            $table->string('client_id', 36)->default('');

			$table->string('action', 30)->default('');

			$table->string('method', 9)->default('');
			$table->string('path', 99)->default('');
			$table->ipAddress('ip')->default('');
			$table->string('input')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_req_logs');
    }
}
