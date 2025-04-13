<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FavoritePostController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\RecoverPasswordController;
use App\Http\Middleware\IsLogged;
use App\Http\Middleware\IsNotLogged;
use App\Models\CommentLikesModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::controller(UserController::class)->group(function() {
    
    Route::middleware(IsNotLogged::class)->group(function () {
        Route::get('login', "login")->name('login');
        Route::post('logining', "logining")->name('logining');

        Route::get('register', "register")->name('register');
        Route::post('registering', "registering")->name('registering');
    });

    Route::middleware(IsLogged::class)->group(function () {
        Route::get('update-user', "updateUser")->name('updateUser');
        Route::post('updating-user', "updatingUser")->name('updatingUser');

        Route::get('delete-user', "deleteUser")->name('deleteUser');

        Route::get('profile', "profile")->name('profile');
        Route::get('delete', "delete")->name('delete');
        Route::get('followers', "followers")->name('followers');
        Route::get('following', "following")->name('following');

        Route::get('see-sent-notifications-by-me', "seeSentNotificationsByMe")->name('seeSentNotificationsByMe');
        Route::get('logout', "logout")->name('logout');
    });
        
});

Route::prefix('category')->controller(CategoryController::class)->group(function() {
    Route::get('getAll', "getAll")->name('category.getAll');
    
    Route::middleware(IsNotLogged::class)->group(function () {
        
    });

    Route::middleware(IsLogged::class)->group(function () {
        Route::get('getAllToAdm', "getAllToAdm")->name('category.getAllToAdm');
        Route::get('save', "save")->name('category.save');
        Route::post('saving', "saving")->name('category.saving');

        Route::get('update/{id}', "update")->name('category.update');
        Route::post('updating', "updating")->name('category.updating');

        Route::get('seeCreater/{id}', "seeCreater")->name('category.seeCreater');

        Route::post('confirm-delete/{id}', "confirmDelete")->name('category.confirmDelete');

        Route::get('change-status/{id}', "changeStatus")->name('category.changeStatus');
    });


});

Route::prefix('posts')->controller(PostController::class)->group(function() {
    
    Route::get('creater/{id}', "creater")->name('post.creater');

    Route::get('see-post-of-user/{id}', "seePostOfUser")->name('post.seePostOfUser');

    Route::get('searchByTitle', "searchByTitle")->name('post.searchByTitle');

    Route::get('get-post/{id}', "getPost")->name('post.getPost');

    Route::get('post-get-by-category/{category}', "getByCategory")->name('post.getByCategory');

    Route::middleware(IsLogged::class)->group(function () {
        Route::get('getAllOfUser', "getAllOfUser")->name('post.getAllOfUser');

        Route::get('save', "save")->name('post.save');
        Route::post('saving', "saving")->name('post.saving');

        Route::get('update/{id}', "update")->name('post.update');
        Route::get('delete/{id}', "delete")->name('post.delete');
        Route::post('updating', "updating")->name('post.updating');
    });

});

Route::prefix('comment')->controller(CommentController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('get-all-comment-of-user', "getAllCommentOfUser")->name('comment.getAllCommentOfUser');

        Route::get('create-comment/{id}', "createComment")->name('comment.create');
        Route::post('creating-comment/{id}', "creatingComment")->name('comment.creating');
    
        Route::get('update-comment/{id}', "update")->name('comment.update');
        Route::post('updating-comment/{id}', "updating")->name('comment.updating');
    
        Route::get('comment-on-comment/{id}', "commentOnComment")->name('comment.commentOnComment');
        Route::post('commenting-on-comment/{id}', "commentingOnComment")->name('comment.commentingOnComment');
    
        Route::get('delete-comment/{id}', "delete")->name('comment.delete');
        Route::get('get-comment/{id}', "getComment")->name('comment.getComment');     
    });
});

Route::prefix('favorite')->controller(FavoritePostController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('post-favorite-of-user', "PostFavoriteOfUser")->name('favoritePost.PostFavoriteOfUser');

        Route::get('to-favorite-post/{id}', "save")->name('favoritePost.save');

        Route::get('remove-favorite-post/{id}', "remove")->name('favoritePost.remove');
    });
});

Route::prefix('follower')->controller(FollowerController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('/follow/{id}','follow')->name('follower.follow');
        Route::get('/unfollow/{id}','unfollow')->name('follower.unfollow');
        Route::get('/followers/{id}','followers')->name('follower.followers');
        Route::get('/following/{id}','following')->name('follower.following');
    });
});

Route::prefix('notification')->controller(NotificationController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('/get/{id}','get')->name('notification.get');

        Route::get('/senderAnNotification','senderAnNotification')->name('notification.senderAnNotification');
        Route::post('/RequestsenderAnNotification','RequestsenderAnNotification')->name('notification.RequestsenderAnNotification');
    
        Route::get('/markWithVisa/{id}','markWithVisa')->name('notification.markWithVisa');
    
        Route::get('/countTotalNotificationNotRead','countTotalNotificationNotRead')->name('notification.countTotalNotificationNotRead');
    
        Route::get('/get-all','getAll')->name('notification.getAll');
    });
});

Route::prefix('like')->controller(PostLikeController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('like/{id}', "like")->name('like.like');
        Route::get('unlike/{id}', "unlike")->name('like.unlike');
        Route::get('see-my-post-like', "seeMyPostLike")->name('like.seeMyPostLike');
        Route::get('api/get/{id}', "get")->name('like.get');
        Route::get('remover/{id}', "remover")->name('like.remover');
    });
});

Route::prefix('comment-like')->controller(CommentLikesController::class)->group(function() {
    Route::middleware(IsLogged::class)->group(function () {
        Route::get('like/{id}', "like")->name('commentLike.like');
        Route::get('unlike/{id}', "unlike")->name('commentLike.unlike');
        Route::get('see-my-comments-likes', "seeMyCommentLike")->name('commentLike.seeMyCommentLike');
        Route::get('api/get/{id}', "get")->name('commentLike.get');
        Route::get('remover/{id}', "remover")->name('commentLike.remover');
    });
});

Route::prefix('password')->controller(RecoverPasswordController::class)->group(function() {
    Route::middleware(IsNotLogged::class)->group(function () {
        Route::get('password-request-form', "requestForm")->name('password.requestForm');
        Route::post('password-check-email', "checkEmail")->name('password.checkEmail');
        Route::post('password-check-token/{email}', "checkToken")->name('password.checkToken');
        Route::post('password-reset', "reset")->name('password.reset');
    });
});

Route::fallback(function(){
    return redirect()->route('index')->with('warning', 'This rounte not exists');
});
