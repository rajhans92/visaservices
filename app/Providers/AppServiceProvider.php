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
        $querMenu = DB::table('menu')
        ->select(
            "menu.id as id",
            "menu.name as name",
            "menu.menu_type as menu_type",
            "menu.status as status",
            "route_visa.visa_url as url"
          )
        ->where('menu.language_id',env('APP_LANG'))
        ->where("menu.status",1)
        ->join('route_visa',"route_visa.id","=","menu.url")
        ->get();

        $menu = [];
        foreach ($querMenu as $key => $value) {
          $menu[$value->menu_type][$value->id]['name'] = $value->name;
          $menu[$value->menu_type][$value->id]['url'] = $value->url;
        }
        // exit(print_r($menu));
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
