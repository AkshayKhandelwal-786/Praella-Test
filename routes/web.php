<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\
{LoginController,RegisterController};
use App\Http\Controllers\{DashboardController, ProjectController, TaskController, UserController, RoleController,  CommentController};

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['isNotAuthenticate'])->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'store')->name('store-login');
    });
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'index')->name('register');
        Route::post('register', 'store')->name('store-register');
    });
});

Route::prefix('admin')->middleware(['isAdmin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('admin.dashboard');
    });
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('comments', CommentController::class);
    Route::post('list-task',[CommentController::class,'getTask'])->name('admin.list-task');
    Route::post('reply-comment',[CommentController::class,'replyComment'])->name('admin.reply-comment');

    Route::match(['get','post'],'assign-permission/{role_id}',[RoleController::class,'updateAssignPermission'])->name('admin.assign-permission');
    
    Route::controller(LoginController::class)->group(function () {
        Route::get('logout', 'logout')->name('admin.logout');
    });
});
