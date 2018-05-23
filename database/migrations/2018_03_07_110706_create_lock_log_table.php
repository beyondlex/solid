<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lock_log', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 32)->unique();
            $table->integer('user_id');
            $table->string('path', 100);
            $table->string('method', 60);
            $table->ipAddress('ip');
            $table->json('input');
            $table->string('desc', 200);
            $table->string('type', 100);
            $table->timestamp('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lock_log');
    }
}
