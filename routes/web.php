<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group([
        'middleware' => 'auth',
    ], function() {
        Route::get('/', "DashboardController@index")->name('dashboard');

        Route::get('/', 'DashboardController@index')
            ->defaults('sidebar', 1)
            ->defaults('icon', 'fas fa-list')
            ->defaults('name', 'Dashboard')
            ->defaults('roles', array('Admin', 'RHU'))
            ->name('dashboard')
            ->defaults('href', '/');

        // USER ROUTES
        $cname = "user";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){
                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
                Route::post("updatePassword/", ucfirst($cname) . "Controller@updatePassword")->name('updatePassword');
            }
        );

        // RHU ROUTES
        $cname = "rhu";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){

                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fas fa-hospital-user")
                    ->defaults("name", "Rural Health Unit")
                    ->defaults("roles", array("Admin"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // BHC ROUTES
        $cname = "bhc";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){

                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fas fa-clinic-medical")
                    ->defaults("name", "Barangay Health Center")
                    ->defaults("roles", array("Admin", "RHU"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // SKU ROUTES
        $cname = "medicine";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){

                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fa-solid fa-capsules")
                    ->defaults("name", "SKU")
                    ->defaults("roles", array("Admin", "RHU"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::get("getCategories/", ucfirst($cname) . "Controller@getCategories")->name('getCategories');
                Route::get("getReorder/", ucfirst($cname) . "Controller@getReorder")->name('getReorder');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("storeCategory/", ucfirst($cname) . "Controller@storeCategory")->name('storeCategory');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("updateCategory/", ucfirst($cname) . "Controller@updateCategory")->name('updateCategory');
                Route::post("updateReorder/", ucfirst($cname) . "Controller@updateReorder")->name('updateReorder');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
                Route::post("deleteReorder/", ucfirst($cname) . "Controller@deleteReorder")->name('deleteReorder');
                Route::post("deleteCategory/", ucfirst($cname) . "Controller@deleteCategory")->name('deleteCategory');

                Route::get("assign/", ucfirst($cname) . "Controller@assign")->name('assign');
            }
        );

        // TRANSACTION TYPE ROUTES
        $cname = "transactionType";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){
                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fa-solid fa-tags")
                    ->defaults("name", "Transaction Type")
                    ->defaults("roles", array("Admin"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // TRANSACTION TYPE ROUTES
        $cname = "data";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){
                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fa-solid fa-keyboard")
                    ->defaults("name", "Data Entry")
                    ->defaults("roles", array("Admin", "RHU"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // REQUEST ROUTES
        $cname = "request";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){
                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fa-light fa-keyboard")
                    ->defaults("name", "Requesition Entry")
                    ->defaults("roles", array("RHU"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::get("create/", ucfirst($cname) . "Controller@create")->name('create');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // APPROVER ROUTES
        $cname = "approver";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){
                Route::get("/", ucfirst($cname) . "Controller@index")
                    ->defaults("sidebar", 1)
                    ->defaults("icon", "fa-solid fa-user-group")
                    ->defaults("name", "Approver")
                    ->defaults("roles", array("Admin"))
                    ->name($cname)
                    ->defaults("href", "/$cname");

                Route::get("get/", ucfirst($cname) . "Controller@get")->name('get');
                Route::post("store/", ucfirst($cname) . "Controller@store")->name('store');
                Route::post("update/", ucfirst($cname) . "Controller@update")->name('update');
                Route::post("delete/", ucfirst($cname) . "Controller@delete")->name('delete');
            }
        );

        // DATATABLES
        $cname = "datatable";
        Route::group([
                'as' => "$cname.",
                'prefix' => "$cname/"
            ], function () use($cname){

                Route::get("rhu", ucfirst($cname) . "Controller@rhu")->name('rhu');
                Route::get("bhc", ucfirst($cname) . "Controller@bhc")->name('bhc');
                Route::get("medicine", ucfirst($cname) . "Controller@medicine")->name('medicine');
                Route::get("medicine2", ucfirst($cname) . "Controller@medicine2")->name('medicine2');
                Route::get("transactionType", ucfirst($cname) . "Controller@transactionType")->name('transactionType');
                Route::get("approver", ucfirst($cname) . "Controller@approver")->name('approver');
                Route::get("requests", ucfirst($cname) . "Controller@requests")->name('requests');
            }
        );
    }
);

require __DIR__.'/auth.php';