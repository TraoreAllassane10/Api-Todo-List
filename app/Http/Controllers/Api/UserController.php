<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "password|min:4"
        ]);

        try {

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  $request->password;

            $user->save();

            return response()->json([
                "status_code" => 200,
                "message" => "Votre compte a été crée avec succès",
                "data" => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status_code" => 500,
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "password|min:4"
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return response()->json([
                    "status_code" => 200,
                    "message" => "Utilisateur connecté"
                ]);
            } else {
                return response()->json([
                    "status_code" => 404,
                    "message" => "Desolé vous n'avez pas de compte"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }
}
