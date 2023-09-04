<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    //

    /**
     * Methode controlleur utilisée pour /api/tags/ : récupérer toutes les taches
     *
     * @return void
     */
    public function list()
    {
        // On récupère toutes les tâches
        $tags = Tag::all()->load(['tasks']);

        // L'encodage JSON est effectué automatiquemant par laravel
        return $tags;
    }

    public function read($id)
    {
        // On récupère une tache
        $tag = Tag::find($id);

        if (!$tag) {
            // Si la tâche n'est pas trouvée, alors on retourne
            // une erreur 404
            return response(null , 404);
        }

        // L'encodage JSON est effectué automatiquemant par laravel
        // On retourne la tâche
        return $tag;
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
            'label'  => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Création de l'objet Tag
        $tag = new Tag();

        // Si echec de validation alors erreur 422
        // Récupération des données du POST
        // Puis mise à jour des données dans l'objet
        $tag->label = $request->input('label');

        // Sauvegarde dans la base via le model Tag.
        if(!$tag->save()) {
            // Erreur 500 si pb de sauvegarde
            return response(null, 500);
        }

        // Code 201 pour création executée
        return response($tag, 201);
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
            'label'  => 'required|max:255'
        ]);

        // Si la validation échoue alors erreur 422
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Récupération de l'objet en DB
        $tag = Tag::find($id);

        // Erreur si pas trouvé
        if (!$tag) {
            return response(null, 404);
        }

        /* Mise à jour des champs
           NB : les champs de la requete peuvent etre accédés directement sous
           la forme $request->champ
           par exemple si on a une requete

           PUT http://127.0.0.1:8000/api/tags/7 HTTP/1.1
           Content-Type: application/json

            {
                "title": "Manger des frites avec du beurre",
                "status": 1
            }

            On pourra accéder a $request->title et $request->status
            ou par $request->input('title') / $request->input('status')
        */
        $tag->label = $request->label;

        if (!$tag->save()) {
            return response(null, 500);
        }

        // Retourne l'objet avec le code par défault :200
        return $tag;

    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return JSONResponse
     */
    public function delete($id)
    {
        $tag = Tag::find($id);

        if ($tag) {
            if (!$tag->delete()) {
                return response(null, 500);
            }
            return response(null, 200);
        } else {
            return response(null, 404);
        }
    }
}
