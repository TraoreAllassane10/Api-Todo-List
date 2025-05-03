<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function index()
    {
        try {
            $todos = TodoResource::collection(Todo::all());

            return response()->json([
                'status_code' => 200,
                'status_message' => "Toutes les taches",
                'data' => $todos
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }
    }


    public function store(TodoRequest $request)
    {
        try {
            $todo = new Todo();

            $todo->title = $request->title;
            $todo->description = $request->description;

            $todo->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => "Tache ajoutée",
                'data' => $todo
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }
    }


    public function show(string $id)
    {
        try {
            $todo = Todo::find($id);

            if (!$todo) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => "Tache non trouvée",
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => "Tache trouvée",
                'data' => new TodoResource($todo)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }
    }

    public function update(TodoRequest $request, string $id)
    {
        try {
            $todo = Todo::find($id);

            if (!$todo) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => "Tache non trouvée",
                ]);
            }

            $todo->title = $request->title;
            $todo->description = $request->description;

            $todo->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => "Tache modifiée",
                'data' => $todo
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $todo = Todo::find($id);

            if (!$todo) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => "Tache non trouvée",
                ]);
            }

            $todo->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => "Tache supprimée",
                'data' => $todo
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }
    }

    public function todos(string $id)
    {

        try {
            $toutesMesTaches = Todo::where('user_id', $id)->get();

            $todos = TodoResource::collection($toutesMesTaches);

            return response()->json([
                'status_code' => 200,
                'status_message' => "Toutes mes taches",
                'data' => $todos
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => "Le serveur ne repond pas! Veuillez réessayer plus tard.",
            ]);
        }

    }
}
