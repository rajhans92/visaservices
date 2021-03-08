<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $querMenu = DB::table('menu')->where('language_id',env('APP_LANG'))->get();
        $menu = [];
        foreach ($querMenu as $key => $value) {
          $menu[$value->title] = $value->name;
        }

        $footerData = DB::table('footer_detail')->where('language_id',env('APP_LANG'))->first();

        Schema::defaultStringLength(191);
        View::share(['menu'=> $menu,'footerData' => $footerData]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        /**
         * Added missing method for package to work
         */
        \Illuminate\Support\Collection::macro('lists', function ($a, $b = null) {
            return collect($this->items)->pluck($a, $b);
        });

    }
}
