<?php

use App\Constants\UserConstant\UserRole;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthenController;
use App\Http\Controllers\Api\CompanyInformationController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RecruitmentPostController;
use App\Http\Controllers\Api\ResumeController;
use App\Http\Controllers\Api\UserController;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthenController::class, 'login'])->name('login');
Route::post('/signup', [AuthenController::class, 'signup'])->name('auth.signup');
Route::get('//unauthenticated', [AuthenController::class, 'throwAuthenError'])->name('auth.authenError');
Route::get('/unauthorized', [AuthenController::class, 'throwAuthorError'])->name('auth.authorError');
Route::post('/send-verify', [AuthenController::class, 'sendVerify'])->name('sendVerify');
Route::post('/active-account', [AuthenController::class, 'activeAccount'])->name('activeAccount');
Route::controller(RecruitmentPostController::class)->prefix('recruitment-posts')->group(function () {
    Route::get('/{id}', 'show')->name('show');
    Route::get('', 'index')->name('index');
});

Route::controller(CompanyInformationController::class)->prefix('companies')->group(function () {
    Route::get('/{id}', 'getCompany')->name('show');
    Route::get('', 'getListCompanies')->name('index');
});

Route::middleware('auth:api')->group(function() {
    Route::middleware('author:' . UserRole::ADMIN)->group(function () {
        Route::controller(UserController::class)->prefix('users')->group(function () {
            Route::get('/', 'index')->name('getAllUser');
        });
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::put('/update-profile', 'updateProfile')->name('updateProfile');
    });

    Route::controller(ResumeController::class)->prefix('resumes')->group(function () {
        Route::get('', 'index')->name('get');
        Route::get('/{id}', 'show')->name('show');
        Route::post('', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('', 'delete')->name('delete');
    });

    Route::controller(ApplicationController::class)->prefix('applications')->group(function () {
        Route::get('', 'index')->name('get');
        Route::get('/posts/{id}', 'getByPost')->name('get');
        Route::get('/{id}', 'show')->name('show');
        Route::post('', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('', 'delete')->name('delete');
    });

    Route::middleware('author:' . UserRole::RECRUITER)->group(function () {
        Route::controller(RecruitmentPostController::class)->prefix('recruitment-posts')->group(function () {
            Route::post('', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::get('/personal/posts', 'getPersonalPosts')->name('getPersonalPosts');
            Route::delete('', 'delete')->name('delete');
        });

        Route::controller(CompanyInformationController::class)->prefix('company-informations')->group(function () {
            Route::get('', 'show')->name('show');
            Route::put('', 'update')->name('update');
        });
    });

    Route::controller(FileController::class)->group(function () {
        Route::post('/upload', 'upload');
    });
    
    Route::controller(AuthenController::class)->group(function () {
        Route::name('auth.')->group(function () {
            Route::post('/logout', 'logout')->name('logout');
            Route::post('/refresh', 'refresh')->name('refresh');
            Route::post('/reset-pass', 'resetPassWord')->name('resetPassword');
            Route::get('/user-profile', 'getUserProfile')->name('getUserProfile');
        });
    });
});
