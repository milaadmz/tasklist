<?php

use App\Http\Controllers\Api\AdminController;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/' , function(){
    return  'Sarmayex Task';
});

//admin route for showiing all users and tasks
Route::get('admin/users', 'App\Http\Controllers\Api\AdminController@users');
Route::get('admin/tasks', 'App\Http\Controllers\Api\AdminController@tasks');


//api for sharing task with admin
Route::post('admin/{task}/share', 'App\Http\Controllers\Api\AdminController@shareTasktoAdmin');


//api routes for user login and register
Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout')->middleware('auth:api');


//api routes for user tasks
Route::get('/tasks', 'App\Http\Controllers\Api\TaskController@index');
Route::get('tasks/{task}', 'App\Http\Controllers\Api\TaskController@show');
Route::post('tasks/create', 'App\Http\Controllers\Api\TaskController@store');
Route::put('tasks/{task}/edit', 'App\Http\Controllers\Api\TaskController@update');
Route::delete('tasks/{task}/delete', 'App\Http\Controllers\Api\TaskController@destroy');

