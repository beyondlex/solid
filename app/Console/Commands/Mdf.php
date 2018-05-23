<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Mdf extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'mdf:enc {value*}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'md5 encryption ';

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
		$value = $this->argument('value');
		//        $this->table(['a','b'], [['a'=>'apple', 'b'=>'banana']]);
		$str = '';
		foreach ($value as $v) {
			$str .= $v;
		}

		$this->info(md5($str));
		//        $this->info(json_encode(config($name)));
	}
}
