<?php

namespace App\Providers;

use App\Http\Controllers\site\MessageController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['site.*'],function ($view){
            $facebook  = MessageController::getSettingDetails('facebook');
            $twitter   = MessageController::getSettingDetails('twitter');
            $instagram = MessageController::getSettingDetails('instagram');
            $snapchat  = MessageController::getSettingDetails('snapchat');
            $youtube   = MessageController::getSettingDetails('youtube');
            $whatsapp  = MessageController::getSettingDetails('whatsapp');
            $title = app()->getLocale() == 'en' ? MessageController::getSettingDetails('title_en') :
                MessageController::getSettingDetails('title_ar');

            if (auth()->check()) {
                $balance = \App\Http\Controllers\site\MainController::getBalance();
            } else
                $balance = 0;

            $view->with('facebook', $facebook)
                ->with('twitter', $twitter)
                ->with('instagram', $instagram)
                ->with('snapchat', $snapchat)
                ->with('youtube', $youtube)
                ->with('whatsapp', $whatsapp)
                ->with('balance', $balance)
                ->with('title', $title);
        });
    }
}
