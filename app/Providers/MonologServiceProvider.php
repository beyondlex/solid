<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class MonologServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
		$monolog = Log::getMonolog();
		/** @var \Monolog\Logger $monolog */
		$monolog->pushHandler(new \App\Extensions\MongoDBHandler());
		$monolog->pushProcessor(new \Monolog\Processor\IntrospectionProcessor(null,
			[
				'Illuminate\\Foundation\\Http\\Kernel',
				'Illuminate\\Log',
				'Illuminate\\Support\\Facades',
			]));
		$monolog->pushProcessor(function($record) {
			if ($req = app('request')->all()) {
				$record['extra']['request'] = $req;
			}
			return $record;
		});
		$webProcessor = new \Monolog\Processor\WebProcessor();
		$webProcessor->addExtraField('user_agent', 'HTTP_USER_AGENT');
		$monolog->pushProcessor($webProcessor);

	}
}
