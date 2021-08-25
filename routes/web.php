<?php

// use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CathegoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FireBrigadeUnitController;
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

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);

    return redirect('/dashboard');
});

Route::group(['middleware' => 'auth'], function () {

    // Route::get('/dashboard', function () {
    //     if (Auth::user()->first_time_login == false)
    //         return Inertia::render('Dashboard', ['user' => Auth::user()]);
    //     else
    //         return redirect('/password-change');
    // })->middleware('verified')->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    Route::group(['middleware' => 'FirstTimeLogin'], function () {
        Route::resource('users', UserController::class, ['names' => ['index' => 'users.index']])->middleware('isAdmin');
        Route::resource('cathegories', CathegoryController::class, ['names' => ['index' => 'cathegories.index']]);
        Route::resource('items', ItemController::class, ['names' => ['index' => 'items.index']]);
        Route::resource('services', ServiceController::class, ['names' => ['index' => 'services.index']]);
        Route::resource('fireBrigadeUnits', FireBrigadeUnitController::class, ['names' => ['index' => 'fireBrigadeUnits.index']])->middleware('isGlobalAdmin');

        Route::get('items/{item}', [ItemController::class, 'itemDetails'])->name('item.details');

        Route::post('services/finish/', [ServiceController::class, 'finish']);
        Route::post('services/activate/{id}', [ServiceController::class, 'activate']);

        Route::post('cathegories/deletePhoto/{id}', [CathegoryController::class, 'deletePhoto']);

        Route::get('scanner', function () {
            return Inertia::render('scanner');
        })->name('scanner');
    });
    Route::get('/password-change', function () {
        return Inertia::render('PasswordChange');
    })->name('password.change');

    Route::post('password-change-store', [UserController::class, 'changePassword'])->name('password.change.store');
});


require __DIR__ . '/auth.php';
