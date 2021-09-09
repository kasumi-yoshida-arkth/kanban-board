<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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
// Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }

    return redirect('/login');
});
Auth::routes();

Route::get('/home', function () {
    return redirect()->route('tasks.index');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('tasks/sync', [TaskController::class, 'sync'])->name('tasks.sync');
    Route::delete('tasks/{tasks}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::group(['middleware' => 'auth'], function() {
    Route::post('statuses', 'StatusCOntroller@store')->name('statuses.store');
    Route::put('statuses/sync', 'StatusController@sync')->name('statuses.sync');
    Route::delete('statuses/{status}', 'StatusController@destroy')->name('statuses.destroy');
});
