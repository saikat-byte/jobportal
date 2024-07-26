<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/job/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/job-apply', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob');
Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.process.forgotPassword');
Route::get('/reset-password/{token}', [AccountController::class, 'resetPassword'])->name('account.reset.password');
Route::post('/process-reset-password', [AccountController::class, 'processResetPassword'])->name('account.process.password');



// Frontend controller
Route::group(["prefix" => "account"], function () {

    // Guest routes
    Route::group(['middleware' => 'guest'], function () {

        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/edit-jobs/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::post('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('/my-job-applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');
        Route::post('/remove-job-applications', [AccountController::class, 'removeJobs'])->name('account.removeJobs');
        Route::get('/saved-jobs', [AccountController::class, 'savedJobs'])->name('account.savedJobs');
        Route::post('/remove-saved-job', [AccountController::class, 'removeSavedJobs'])->name('account.removeSavedJobs');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');


    });
});

// admin controller

Route::group(["prefix"=> "admin", 'middleware' => 'checkRole'], function(){


    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/users/delete', [UserController::class, 'destroy'])->name('admin.user.delete');
    Route::get('/jobs', [JobController::class, 'index'])->name('admin.job');
    Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('admin.jobs.edit');
    Route::put('/update-job/{jobId}', [JobController::class, 'updateJob'])->name('admin.jobs.update');
    Route::delete('/job/delete', [JobController::class, 'destroy'])->name('admin.jobs.delete');
    Route::get('/job/applications', [JobApplicationController::class, 'index'])->name('admin.job.application');
    Route::delete('/job/applications/delete', [JobApplicationController::class, 'destroy'])->name('admin.jobApplication.delete');



});
