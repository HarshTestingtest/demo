<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Admin\AdminAuthController;


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

// Forget Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Login with Google account
Route::get('login/google', [AuthController::class, 'redirectToProvider']);
Route::get('login/google/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware(Authcheck::class); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('profileUpdate',[UserController::class,'profileUpdate'])->name('profileUpdate')->middleware(Authcheck::class);
Route::post('post-profileUpdate',[UserController::class,'postProfileUpdate'])->name('updateProfile.post')->middleware(Authcheck::class);
Route::post('get-states-by-country',[AuthController::class,'getState']);
Route::post('get-cities-by-state',[AuthController::class,'getCity']);
Route::get('refereshcapcha',[AuthController::class,'refereshCapcha']);
Route::get('lang/change', [AuthController::class, 'change'])->name('changeLang');

// login with OTP
Route::controller(OtpController::class)->group(function(){
    Route::get('otp/login', 'login')->name('otp.login');
    Route::post('otp/generate', 'generate')->name('otp.generate');
    Route::get('otp/verification/{user_id}', 'verification')->name('otp.verification');
    Route::post('otp/login', 'loginWithOtp')->name('otp.getlogin');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    
    
    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');    
        Route::get('/showdata', [AdminAuthController::class, 'viewData'])->name('adminShowdata');
        Route::get('/export-csv', [AdminAuthController::class, 'exportCSV']);
        Route::get('/status-update/{id}',[AdminAuthController::class,'statusUpdate'])->name('status-update');
        Route::get('/', function () {
            return view('admindashboard');
        })->name('adminDashboard');

    });
});

