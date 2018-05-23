<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Api\Zk\Services\Zk;

class ZkLockCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zk:lock 
                            {sn : serial number of lock. eg. "AIO9180160472"} 
                            {operation : operation name.} 
                            {--cmd= : command. eg. "data query userinfo", "reload options"}
                            {--pin= : The pin of user.}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        send a cmd to lock.
        eg: 
            php artisan zk:lock AIO9180160472 info 
            php artisan zk:lock AIO9180160472 reload 
            php artisan zk:lock AIO9180160472 reboot 
            php artisan zk:lock AIO9180160472 common  --cmd="info"
    ';

    protected $zk;

    /**
     * Create a new command instance.
     *
     * @param Zk $zk
     */
    public function __construct(Zk $zk)
    {
        parent::__construct();
        $this->zk = $zk;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $sn = $this->argument('sn');

        $op = $this->argument('operation');

        if ($op == 'attendLogToday') {

            $this->zk->cmdAttendanceLog($sn);
        }
        else if ($op == 'info') {
            $this->zk->cmdInfo($sn);
        }

        else if ($op == 'reload') {
            $this->zk->cmdReload($sn);
        }
        else if ($op == 'reboot') {
            $this->zk->cmdReboot($sn);
        }

        else if ($op == 'users') {
            $this->zk->cmdUser($sn);
        }

        else if ($op == 'delUser') {
            $pin = $this->option('pin');
            if (!$pin) {
                $this->error('pin can not be empty');
                exit;
            }
            $this->zk->cmdDelUser($sn, $pin);
        }



        else if ($op == 'common') {
            $cmd = $this->option('cmd');
            if (!$cmd) {
                $this->error('cmd can not be empty');
                exit;
            }
            $cmd = strtoupper($cmd);
            $this->zk->cmd($sn, $cmd);
        }

    }
}
