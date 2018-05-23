<?php

namespace App\Console\Commands;

use Api\Hik\Libs\Com\Hikvision\Cms\Api\Eps\Beds\CommEventLog;
use Illuminate\Console\Command;
use Mosquitto\Client;

class MosquittoSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:sub {topic} {qos=0 : the QoS } {--i|ip=127.0.0.1} {--p|port=1883} {--P|password=} {--u|username=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a topic';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //php artisan mosquitto:sub hello -p 18830 -u lex -P 123123

		$serverIp = $this->option('ip');
		$username = $this->option('username');
		$password = $this->option('password');
		$topic = $this->argument('topic');
		$qos = $this->argument('qos');
		$port = $this->option('port');
		$client  = new Client();

		$client->onConnect(function($rc, $message) {
			$this->info($message);
		});
		$client->onMessage(function($msg) {
		    $time = date('Y-m-d H:i:s');
		    echo "\n -------------------------------------------------------- {$time}\n";
			print_r($msg);
			try {

                $eventLog = new CommEventLog();
                $eventLog->mergeFromString($msg->payload);
                var_dump($eventLog->getLogId());//string(36)
                var_dump($eventLog->getEventState());
                var_dump($eventLog->getEventLevel());
                var_dump($eventLog->getUnitIdx());//string(32)
                var_dump($eventLog->getEventType());//131614
                var_dump($eventLog->getEventTypeName());//人脸抓拍
                var_dump($eventLog->getSubSysType());
                var_dump($eventLog->getEventName());
                var_dump($eventLog->getStartTime());
                var_dump($eventLog->getStopTime());
                var_dump($eventLog->getSourceIdx());
                var_dump($eventLog->getSourceType());//32800
                var_dump($eventLog->getSourceName());//Camera 01
                var_dump($eventLog->getLogTxt());
                var_dump($eventLog->getExtInfo());//xml or json or ...


            } catch (\Exception $e) {
			    var_dump($e);
            }

		});
		$client->onDisconnect(function() {
			$this->info('disconnect.');
		});

		$client->setWill('Somebody died.', 'Good bye ... ', 0, false);

		if ($username and $password) {
			$client->setCredentials($username, $password);
		}
		$client->connect($serverIp, $port);
		$client->subscribe($topic, $qos);
		$client->loopForever();

		$client->disconnect();
		unset($client);
    }
}
