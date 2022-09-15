<?php

namespace App\Console;

use App\Console\Commands\CreateLog;
use App\Models\Advertising;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         CreateLog::class
     ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        ///usr/local/bin/php /home/ajrnnaxa/private/artisan schedule:run
        //$schedule->command('queue:restart')->everyThirtyMinutes();
        //$schedule->command('queue:restart')->everyMinute();
        $schedule->call(function () {
            $files = File::allFiles(public_path('resources/tempUploads/'));
            foreach ($files as $file){
                if ( time() - $file->getCTime() > 5 * 60 * 60 )
                    unlink($file->getRealPath());
            }
        })->daily()->at('3:30');

        $schedule->call(function () {
            foreach(Advertising::where('status' , 'accepted')->whereDate('expire_at' , Carbon::now())->where('auto_extend' , 1 )->get() as $ad) {
                $isValid = \App\Http\Controllers\Controller::isValidCreateAdvertising($ad->user_id, $ad->advertising_type);
                if ($isValid) {
                    //DB::beginTransaction();
                    $countShowDay =  \App\Http\Controllers\Controller::affectCreditUser($ad->user_id, $ad->advertising_type);
                    $today = date("Y-m-d");
                    $date = strtotime("+$countShowDay day", strtotime($today));
                    $expireDate = date("Y-m-d", $date);
                    $ad->expire_at = $expireDate;
                    $ad->save();
                    echo $ad->id ."\n";
                    //DB::commit();
                }
            }
        })->daily()->at('12:30');
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
