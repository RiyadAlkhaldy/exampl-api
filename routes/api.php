<?php

use App\Events\NotificationRecieved;
use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollogeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
 

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('posts',PostController::class);


// Route::apiResource('photos', PostController::class)->only([
//     'create', 'store', 'update', 'destroy','index','destroy','edit','show', 
// ]);

// Route::get('login',[AuthController::class, 'login']);
// Route::get('login', 'AuthController@login');

// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {

//     Route::post('login', '\App\Http\Controllers\AuthController@login');
//     Route::post('logout', '\App\Http\Controllers\AuthController@logout');
//     Route::post('refresh', '\App\Http\Controllers\AuthController@refresh');
//     Route::post('me', '\App\Http\Controllers\AuthController@me');

// });

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('eexel', 'eexel');
    
    Route::get('me', 'me');

});
Route::controller(CollogeController::class)->prefix('colloge')->group(function () {
    Route::get('index', 'index');
    Route::post('get-colloge-posts', 'getCollogePosts');

    

});
Route::controller(SectionController::class)->prefix('section')->group(function () {
    Route::get('index', 'index');
    Route::post('get-section-posts', 'getSectionPosts');

    

});
// Route::controller(PostController::class)->prefix('post')->group(function () {
//     Route::get('index', 'index');
    

// });
Route::controller(PostController::class)->prefix('posts') ->group(function (){
    Route::post('store', 'store');
    Route::post('storefile', 'storeFile');
    Route::post('edit', 'edit');
    Route::post('destroy', 'destroy');
    Route::post('showNotifications', 'showNotifications');
    Route::post('index', 'getAllPosts');
});
Route::controller(CommentController::class)->prefix('comment')->group(function () {
    Route::post('get-all-comments', 'getAllComments');
    Route::post('add-comments', 'addComment');
    Route::post('get-all-comments', 'getAllComments');
    

});

// Route::post('/v1/file_upload', 'App\Http\Controllers\Api\v1\ApiController@file_upload');

Route::controller(ApiController::class)->prefix('v1')->group(function (){
    
    Route::post( 'file_upload',  'file_upload');
    
});

Route::get('/noty', function (Request $request) {
    
   return   event(new NotificationRecieved( $request->msg));
             
});
Route::apiResource('users',UserController::class);





// Route::controller(UserController::class)->prefix('user')->group(function () {
//     Route::post('', 'index');
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
//     Route::get('me', 'me');

// });