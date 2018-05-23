<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_passwords', function (Blueprint $table) {
            $table->string('id', 36);
            $table->primary('id');
            $table->string('value', 16)->default('');
            $table->string('device_id', 36)->default('');
            $table->string('origin_id', 36)->comment('密码原始ID')->default('');
            $table->integer('times')->comment('有效次数：1.一次；-1.无限次')->default(1);
            $table->timestamp('s_time')->comment('开始时间')->nullable();
            $table->timestamp('e_time')->comment('结束时间')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('device_passwords');
    }
}
