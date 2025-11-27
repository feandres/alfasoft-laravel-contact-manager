<?php

use App\Http\Controllers\ContactController;
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


//CONTACTS
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::get('/{contact}', [ContactController::class, 'show'])->name('contacts.show');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/edit/{contact}', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/delete/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::delete('/contacts/wipe/{contact}', [ContactController::class, 'wipe'])->name('contacts.wipe');
Route::patch('/contacts/restore/{contact}', [ContactController::class, 'restore'])->name('contacts.restore');

