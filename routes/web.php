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
Route::get('/admin/settings', [AdminController::class, 'settings'])->middleware('isAdmin')->name('admin.settings');
    //admin project routes
    Route::get('/admin/deleteProject/{id}', [AdminController::class, 'deleteProject'])->middleware('isAdmin')->name('admin.deleteProject');
    Route::post('/admin/storeProject', [AdminController::class, 'storeProject'])->middleware('isAdmin')->name('admin.storeProject');
    Route::get('/admin/getProject/{id}', [AdminController::class, 'getProject'])->middleware('isAdmin')->name('admin.getProject');
    Route::put('/admin/updateProject/{id}', [AdminController::class, 'updateProject'])->middleware('isAdmin')->name('admin.updateProject');

    //admin module routes
    Route::post('/admin/storeModule', [AdminController::class, 'storeModule'])->middleware('isAdmin')->name('admin.storeModule');
    Route::get('/admin/deleteModule/{id}', [AdminController::class, 'deleteModule'])->middleware('isAdmin')->name('admin.deleteModule');
    Route::get('/admin/getModule/{id}', [AdminController::class, 'getModule'])->middleware('isAdmin')->name('admin.getModule');
    Route::put('/admin/updateModule/{id}', [AdminController::class, 'updateModule'])->middleware('isAdmin')->name('admin.updateModule');
Route::get('/admin/updateTicketStatus/{id}/{status}', [AdminController::class, 'updateTicketStatus'])->middleware('isAdmin')->name('admin.updateTicketStatus');