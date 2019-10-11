<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        //
        Passport::routes();
        Validator::extend('uniqueUserType', function ($attribute, $value, $parameters, $validator) {
//           var_dump(array($attribute,$value,$parameters));exit;
             $count = DB::table('users')->where('phoneNumber', $value)
                ->where('loginType', $parameters[2])
                ->count();
            return $count === 0;
        });
    }
}
