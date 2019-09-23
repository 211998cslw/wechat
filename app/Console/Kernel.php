<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tools\Tools;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
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
//        $schedule->call(function(){
//            //功能 业务逻辑
//            $tools=new Tools();
//            $data=[
//                'touser'=>[
//                    "OPENID1",
//                    "OPENID2"
//                ],
//                'mpnews'=>[
//                    'media_id'='123dsdajkasd231jhksad'
//                ],
//                'msgtype'='mpnews',
//                'send_ignore_reprint'=0
//            ];
//            $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->get_wechat_access_token();
////            dd($url);
//            $this->post_url($url,$data);
//        })
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
