<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les api tasks
Route::get    ('/tasks'     , [TaskController::class, 'list']);         // Liste des taches :               endpoint /api/tasks      | GET
Route::get    ('/tasks/{id}', [TaskController::class, 'read']);         // Récupération d'une seule tache - endpoint /api/tasks/{id} | GET
Route::post   ('/tasks'     , [TaskController::class, 'create']);       // Création d'une tache -           endpoint /api/tasks      | POST
Route::put    ('/tasks/{id}', [TaskController::class, 'update']);       // MAJ d'une tache -                endpoint /api/tasks/{id} | PUT
Route::delete ('/tasks/{id}', [TaskController::class, 'delete']);       // Suppression d'une tache -        endpoint /api/tasks/{id} | DELETE

// Routes pour les api categories
Route::get    ('/categories'     , [CategoryController::class, 'list']);         // Liste des categories :               endpoint /api/categories      | GET
Route::get    ('/categories/{id}', [CategoryController::class, 'read']);         // Récupération d'une seule categorie - endpoint /api/categories/{id} | GET
Route::post   ('/categories'     , [CategoryController::class, 'create']);       // Création d'une categorie -           endpoint /api/categories      | POST
Route::put    ('/categories/{id}', [CategoryController::class, 'update']);       // MAJ d'une categorie -                endpoint /api/categories/{id} | PUT
Route::delete ('/categories/{id}', [CategoryController::class, 'delete']);       // Suppression d'une categorie -        endpoint /api/categories/{id} | DELETE

// Routes pour les api tags
Route::get    ('/tags'     , [TagController::class, 'list']);         // Liste des tags :               endpoint /api/tags      | GET
Route::get    ('/tags/{id}', [TagController::class, 'read']);         // Récupération d'un seul tag -   endpoint /api/tags/{id} | GET
Route::post   ('/tags'     , [TagController::class, 'create']);       // Création d'un tag -            endpoint /api/tags      | POST
Route::put    ('/tags/{id}', [TagController::class, 'update']);       // MAJ d'un tag -                 endpoint /api/tags/{id} | PUT
Route::delete ('/tags/{id}', [TagController::class, 'delete']);       // Suppression d'un tag -         endpoint /api/tags/{id} | DELETE
