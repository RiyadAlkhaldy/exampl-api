<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\User;
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
        User::created(function ($user) {
         $newUser =   Notification::create([
                'user_id' => $user->id,
                'title' => 'New User',
                'body'=>'you have new account in our system',
                'type' => 'success',
                'url' => 'success',
            ]);
            $newUser->save();    
            
             });
    }
}