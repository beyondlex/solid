<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_categories', function (Blueprint $table) {
            $table->string('id', 36);
            $table->primary('id');
            $table->string('name');
            $table->string('code', 99)->unique();
            $table->string('parent_id', 36)->nullable();
			$table->unsignedInteger('lft')->default(0);
			$table->unsignedInteger('rgt')->default(0);
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
        Schema::dropIfExists('device_categories');
    }
}
