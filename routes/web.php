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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('get_empduty', 'DutyController@get_empduty')->name('get_empduty');

Route::group(['middleware' => 'auth'], function(){
    Route::resources([
        'employees' => 'EmployeeController',
        'duties' => 'DutyController',
        'leaves' => 'LeaveController',
        'records' => 'RecordController'
    ]);
});

Route::get('/admin-references', function () {
    return view('references.index');
})->name('references');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
