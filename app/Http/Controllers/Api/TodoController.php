<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status_code' => 200,
            'status_message' => "Tache ajoutée",
            'data' => Todo::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        $todo = new Todo();

        $todo->title = $request->title;
        $todo->description = $request->description;

        $todo->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => "Tache ajoutée",
            'data' => $todo
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, string $id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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

    }
}
