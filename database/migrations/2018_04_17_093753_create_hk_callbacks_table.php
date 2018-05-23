<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHkCallbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hk_callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->unique();
            $table->string('back_code');
            $table->char('auth_code', 32);
            $table->string('type')->comment('事件回调类型');
            $table->binary('events')->comment('二进制表示事件集');
            $table->integer('client_id');
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
        Schema::dropIfExists('hk_callbacks');
    }
}
