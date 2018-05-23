<?php

namespace App\Console;

use App\Console\Commands\ConfigList;
use App\Console\Commands\FacadeInfo;
use App\Console\Commands\ZkLockCmd;
use App\Console\Commands\Mdf;
use App\Console\Commands\MosquittoPub;
use App\Console\Commands\MosquittoSub;
use App\Console\Commands\SendMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Api\Zk\Jobs\AttendanceLogRefresh;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        FacadeInfo::class,
		SendMail::class,
		ConfigList::class,
		Mdf::class,
		MosquittoSub::class,
		MosquittoPub::class,
        ZkLockCmd::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //$schedule->command('zk:lock AIO9180160472 attendLogToday')
        //    ->everyMinute()
        //    ->appendOutputTo(base_path('job.log'))
        //;
        //$schedule->job(new AttendanceLogRefresh())->dailyAt('01:00');//每天01:00执行锁打卡数据同步任务
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
