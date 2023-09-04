<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    /**
     * Methode controlleur utilisée pour /api/Categories/ : récupérer toutes les taches
     *
     * @return void
     */
    public function list()
    {
        // On récupère toutes les tâches
        $categories = Category::all();

        // L'encodage JSON est effectué automatiquemant par laravel
        return $categories;
    }

    public function read($id)
    {
        // On récupère une tache
        $category = Category::find($id);

        if (!$category) {
            // Si la tâche n'est pas trouvée, alors on retourne
            // une erreur 404
            return response(null , 404);
        }

        // L'encodage JSON est effectué automatiquemant par laravel
        // On retourne la tâche
        return $category;
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
            'name'  => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Création de l'objet Category
        $category = new Category();

        // Si echec de validation alors erreur 422
        // Récupération des données du POST
        // Puis mise à jour des données dans l'objet
        $category->name = $request->name;

        // Sauvegarde dans la base via le model Category.
        if(!$category->save()) {
            // Erreur 500 si pb de sauvegarde
            return response(null, 500);
        }

        // Code 201 pour création executée
        return response($category, 201);
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
            'name'  => 'required|max:255'
        ]);

        // Si la validation échoue alors erreur 422
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Récupération de l'objet en DB
        $category = Category::find($id);

        // Erreur si pas trouvé
        if (!$category) {
            return response(null, 404);
        }

        /* Mise à jour des champs
           NB : les champs de la requete peuvent etre accédés directement sous
           la forme $request->champ
           par exemple si on a une requete

           PUT http://127.0.0.1:8000/api/categories/7 HTTP/1.1
           Content-Type: application/json

            {
                "title": "Manger des frites avec du beurre",
                "status": 1
            }

            On pourra accéder a $request->title et $request->status
            ou par $request->input('title') / $request->input('status')
        */
        $category->name = $request->name;

        if (!$category->save()) {
            return response(null, 500);
        }

        // Retourne l'objet avec le code par défault :200
        return $category;

    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return JSONResponse
     */
    public function delete($id)
    {
        $category = Category::find($id);

        if ($category) {

            // Suppression dans la database
            $resultat = $category->delete();
            if ($resultat === true) {
                return response(null, 200);
            } else {
                return response(null, 500);
            }
        } else {
            return response(null, 404);
        }
    }
}
