<?php

include_once 'auth.php';
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;


//global redirect
Route::get('/', function(){
    if(auth()->user()){
        if(auth()->user()->type == 'admin'){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

//user routes
Route::get('/user/dashboard', [UserController::class, 'index'])->middleware('auth')->name('user.dashboard');
Route::post('/user/storeTicket', [UserController::class, 'storeTicket'])->middleware('auth')->name('user.storeTicket');
Route::get('/user/deleteTicket/{id}', [UserController::class, 'deleteTicket'])->middleware('auth')->name('user.deleteTicket');
Route::get('/user/getTicket/{id}', [UserController::class, 'getTicket'])->middleware('auth')->name('user.getTicket');
Route::put('/user/updateTicket/{id}', [UserController::class, 'updateTicket'])->middleware('auth')->name('user.updateTicket');

//admin routes
Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('isAdmin')->name('admin.dashboard');
