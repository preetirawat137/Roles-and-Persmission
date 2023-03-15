<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SampleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/welcome', function () {
//     // sleep(6);
//     return view('welcome');
// });
Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get', function () {           
    return view('CustomAuth.main');
});


Route::get('/home',[SampleController::class,'index'])->name('home');
Route::get('/register',[SampleController::class,'registration']);
Route::post('/validate_register',[SampleController::class,'validate_register'])->name('validate_register');
Route::get('/login',[SampleController::class,'loginview'])->name('login');
Route::post('/login',[SampleController::class,'login']);
Route::get('/logout',[SampleController::class,'logout']);
Route::get('/dashboard',[SampleController::class,'dashboard'])->name('dashboard');
Route::get('/forgetPasswordLoad', [SampleController::class, 'forgetPasswordLoad'])->name('forgetPasswordLoad');
Route::post('/forgetPasswordLink', [SampleController::class, 'forgetPasswordLink']);
 
Route::get('/ResetPasswordLoad/{token}', [SampleController::class, 'ResetPasswordLoad']);   
Route::post('/Resetpassword', [SampleController::class, 'Resetpassword'])->name('Resetpassword'); 

?>
