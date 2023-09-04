<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //

    /**
     * Methode controlleur utilisée pour /api/tasks/ : récupérer toutes les taches
     *
     * @return void
     */
    public function list()
    {
        // On récupère toutes les tâches
        // Et on loade les relations de la table
        $tasks = Task::all()->load(['category', 'tags']);

        // L'encodage JSON est effectué automatiquemant par laravel
        return $tasks;
    }

    public function read($id)
    {
        // On récupère une tache
        $task = Task::find($id);

        if (!$task) {
            // Si la tâche n'est pas trouvée, alors on retourne
            // une erreur 404
            return response(null , 404);
        }

        // L'encodage JSON est effectué automatiquemant par laravel
        // On retourne la tâche
        return $task;
    }

    /**
     * Creation d'une tache
     *
     * @param Request $request
     * @return JSONResponse
     */
    public function create(Request $request)
    {
        // Validation des données

        $validator = Validator::make($request->all(), [
            'title'  => 'required|max:255',
            'status' => 'integer'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Création de l'objet Task
        $task = new Task();

        // Si echec de validation alors erreur 422
        // Récupération des données du POST
        // Puis mise à jour des données dans l'objet
        $task->title = $request->input('title');
        $task->status = $request->has('status') ? $request->input('status') : 0;

        // Sauvegarde dans la base via le model Task.
        if(!$task->save()) {
            // Erreur 500 si pb de sauvegarde
            return response(null, 500);
        }

        // Code 201 pour création executée
        return response($task, 201);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param Request $request
     * @return JSONResponse
     */
    public function update($id, Request $request)
    {
        // Validation des données

        $validator = Validator::make($request->all(), [
            'title'  => 'required|max:255',
            'status' => 'required|integer'
        ]);

        // Si la validation échoue alors erreur 422
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Récupération de l'objet en DB
        $task = Task::find($id);

        // Erreur si pas trouvé
        if (!$task) {
            return response(null, 404);
        }

        /* Mise à jour des champs
           NB : les champs de la requete peuvent etre accédés directement sous
           la forme $request->champ
           par exemple si on a une requete

           PUT http://127.0.0.1:8000/api/tasks/7 HTTP/1.1
           Content-Type: application/json

            {
                "title": "Manger des frites avec du beurre",
                "status": 1
            }

            On pourra accéder a $request->title et $request->status
            ou par $request->input('title') / $request->input('status')
        */
        $task->title = $request->title;
        $task->status = $request->status;

        if (!$task->save()) {
            return response(null, 500);
        }

        // Retourne l'objet avec le code par défault :200
        return $task;

    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return JSONResponse
     */
    public function delete($id)
    {
        $task = Task::find($id);

        if ($task) {
            if (!$task->delete()) {
                return response(null, 500);
            }
            return response(null, 200);
        } else {
            return response(null, 404);
        }
    }
}
