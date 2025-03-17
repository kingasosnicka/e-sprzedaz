<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return view('home');
});

Route::get('/pet/add', [PetController::class, 'create']); // formularz dodawania zwierzaka
Route::post('/pet/add', [PetController::class, 'store']); // obsługa formularza dodającego

Route::get('/pet/edit', [PetController::class, 'edit']); // formularz edycji zwierzaka
Route::post('/pet/edit', [PetController::class, 'update']); // obsługa formularza edycji

Route::get('/pet/delete', [PetController::class, 'delete']); // formularz usuwania zwierzaka
Route::post('/pet/delete', [PetController::class, 'destroy']); // obsługa formularza usuwania

Route::get('/pet/find', [PetController::class, 'find']); // formularz wyszukiwarki zwierzaka
Route::post('/pet/find', [PetController::class, 'search']); // obsługa formularza wyszukiwarki