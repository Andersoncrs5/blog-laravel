<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::controller(UserController::class)->group(function() {
    Route::get('login', "login")->name('login');
    Route::post('logining', "logining")->name('logining');

    Route::get('register', "register")->name('register');
    Route::post('registering', "registering")->name('registering');

    Route::get('update-user', "updateUser")->name('updateUser');
    Route::post('updating-user', "updatingUser")->name('updatingUser');

    Route::get('delete-user', "deleteUser")->name('deleteUser');
    //Route::post('updating-user', "updatingUser")->name('updatingUser');

    Route::get('profile', "profile")->name('profile');
    Route::get('delete', "delete")->name('delete');

    Route::get('logout', "logout")->name('logout');

});

Route::prefix('category')->controller(CategoryController::class)->group(function() {
    Route::get('getAll', "getAll")->name('category.getAll');
    Route::get('getAllToAdm', "getAllToAdm")->name('category.getAllToAdm');

    Route::get('save', "save")->name('category.save');
    Route::post('saving', "saving")->name('category.saving');

    Route::get('update/{id}', "update")->name('category.update');
    Route::post('updating', "updating")->name('category.updating');

    Route::get('seeCreater/{id}', "seeCreater")->name('category.seeCreater');

    Route::post('confirm-delete/{id}', "confirmDelete")->name('category.confirmDelete');

    Route::get('change-status/{id}', "changeStatus")->name('category.changeStatus');

});

Route::prefix('posts')->controller(PostController::class)->group(function() {
    Route::get('getAllOfUser', "getAllOfUser")->name('post.getAllOfUser');

    Route::get('save', "save")->name('post.save');
    Route::post('saving', "saving")->name('post.saving');

    Route::get('update/{id}', "update")->name('post.update');

    Route::get('delete/{id}', "delete")->name('post.delete');

    Route::post('updating', "updating")->name('post.updating');

    Route::get('get-post/{id}', "getPost")->name('post.getPost');

    Route::get('post-get-by-category/{category}', "getByCategory")->name('post.getByCategory');

});

Route::fallback(function(){
    return Redirect()->route('index')->with('warning', 'This rounte not exists');
});
