<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSheetController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('projects', App\Http\Controllers\ProjectController::class);

Route::get('/showbyproject', [App\Http\Controllers\TimesheetController::class, 'showbyproject'])->name('showbyproject');

Route::resource('phases', App\Http\Controllers\PhaseController::class);

Route::resource('timesheets', App\Http\Controllers\TimesheetController::class);

Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');

Route::get('/fetch-phases',  [App\Http\Controllers\TimesheetController::class, 'fetchPhases'])->name('fetchPhases');

// routes/web.php
Route::get('/close-tab', function () {
    return view('close_tab');
})->name('closeTab');

Route::get('/export-timesheets-csv',  [App\Http\Controllers\ExportController::class, 'timesheetsExportCSV'])->name('export.timesheets.csv');

Route::get('/export-timesheets-pdf',  [App\Http\Controllers\ExportController::class, 'timesheetsExportPDF'])->name('export.timesheets.pdf');