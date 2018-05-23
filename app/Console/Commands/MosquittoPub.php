<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mosquitto\Client;

class MosquittoPub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mosquitto:pub {topic} {message} {qos=0} {--p|port=1883} {--u|username=} {--P|password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish message to a topic.';

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
        //php artisan mosquitto:pub hello hi -p 18830 -u lex -P 123123
		$serverIp = '127.0.0.1';
		$topic = $this->argument('topic');
		$message = $this->argument('message');
		$qos = $this->argument('qos');
		$port = $this->option('port');
		$username = $this->option('username');
		$password = $this->option('password');
		$client  = new Client();

		$client->onConnect(function($rc, $message) {
			$this->info($message);
		});
		$client->onPublish(function($msgId) {
			$this->info('Published a message with id: '. $msgId);
		});
		$client->onDisconnect(function() {
			$this->info('disconnect.');
		});

		if ($username and $password) {
			$client->setCredentials($username, $password);
		}

		$client->connect($serverIp, $port);
		$client->publish($topic, $message, $qos);

		$client->disconnect();
		unset($client);
    }
}
