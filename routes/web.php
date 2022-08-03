<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/* rota que chama a view principal, apenas */
Route::get('students', [StudentController::class, 'index']);

/* rota que chama a função 'fetchstudent' para trazer os dados já consistidos para a view */
Route::get('fetch-students', [StudentController::class, 'fetchstudent']);

/* rota que chama a função 'store', que salva dados no banco */
Route::post('students', [StudentController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});
