<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateClientConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var Schema $schema */
        $schema = app('db')->connection('mongodb')->getSchemaBuilder();
        $schema->create('client_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id', 36);
            $table->unique('client_id');
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
        /** @var Schema $schema */
        $schema = app('db')->connection('mongodb')->getSchemaBuilder();
        $schema->dropIfExists('client_configs');
    }
}
