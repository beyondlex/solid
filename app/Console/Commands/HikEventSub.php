<?php

namespace App\Console\Commands;

use Api\Hik\Events\HikEvent;
use Api\Hik\Libs\Com\Hikvision\Cms\Api\Eps\Beds\CommEventLog;
use Illuminate\Console\Command;
use Mosquitto\Client;

/**
 * Class HikEventSub
 *
 * required: php extension php71-mosquitto is installed.
 *
 * @package App\Console\Commands
 *
 * @see https://github.com/mgdm/Mosquitto-PHP
 */
class HikEventSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hik:sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe for Hikvision events. ';

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
        //
        $serverIp = config('application.devices.vendors.hik.server_ip');
        $port = config('application.devices.vendors.hik.mqtt_port');

        //$username = $this->option('username');
        //$password = $this->option('password');
        $topic = 'openapi/#';
        $qos = 0;
        //$qos = $this->argument('qos');

        $client  = new Client();

        $client->onConnect(function($rc, $message) {
            $this->info($message);
        });
        $client->onMessage(function($msg) {

            $this->info($msg->topic. ' '. date('Y-m-d H:i:s'));

            //触发HikEvent事件
            event(new HikEvent($msg->topic, $msg->payload));

        });
        $client->onDisconnect(function() {
            $this->info('disconnect.');
        });

        //$client->setWill('Somebody died.', 'Good bye ... ', 0, false);

        //if ($username and $password) {
        //    $client->setCredentials($username, $password);
        //}
        $client->connect($serverIp, $port);
        $client->subscribe($topic, $qos);
        $client->loopForever();

        $client->disconnect();
        unset($client);
    }
}
