<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CathegoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', UserController::class, ['names' => ['index' => 'users.index']])->middleware(['auth','isAdmin']);
Route::resource('cathegories', CathegoryController::class, ['names' => ['index' => 'cathegories.index']])->middleware(['auth']);
Route::resource('items', ItemController::class, ['names' => ['index' => 'items.index']])->middleware(['auth']);
Route::resource('services', ServiceController::class, ['names' => ['index' => 'services.index']])->middleware(['auth']);

require __DIR__ . '/auth.php';
