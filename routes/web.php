<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/* rota que chama a view principal, apenas */
Route::get('students', [StudentController::class, 'index']);

/* rota que chama a função 'fetchstudent' para trazer os dados já consistidos para a view */
Route::get('fetch-students', [StudentController::class, 'fetchstudent']);

/* rota que chama a função 'store', que salva dados no banco */
Route::post('students', [StudentController::class, 'store']);

/* rota que busca os dados do objeto utilizando o 'id' para posteriormente serem editados */
Route::get('edit-student/{id}', [StudentController::class, 'edit']);

/* rota que após ter os dados de edit em mãos, os submete atualizados ou editados para o banco */
Route::put('update-student/{id}', [StudentController::class, 'update']);

Route::get('/', function () {
    return view('welcome');
});
