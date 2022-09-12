<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

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
        view()->composer('*',function($view) {
            $theme = DB::table('themes');

            if(isset(auth()->user()->role)){
                if(auth()->user()->role == "Admin"){
                    $theme = $theme->where('admin_id', auth()->user()->id);
                }
                elseif(auth()->user()->role == "RHU"){
                    $theme = $theme->join('rhus as r', 'r.admin_id', '=', 'themes.admin_id');
                    $theme = $theme->where('r.user_id', auth()->user()->id);
                }

                $view->with('theme', $theme->pluck('value', 'name'));
            }
            elseif(isset($_GET['u'])){
                $theme = $theme->where('admin_id', $_GET['u']);
                $view->with('theme', $theme->pluck('value', 'name'));
            }
        });
    }
}
