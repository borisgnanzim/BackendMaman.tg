<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Vérification de la longueur du mot de passe
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => 2, // Rôle utilisateur par défaut
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string',
        ]);  

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token',[$user->role->name ?? ''])->plainTextToken;

        $cookie = cookie('auth_token', $token, 1440, null, null, false, true); // Sécuriser le cookie

        return response()->json([
            'message' => 'User logged successfully',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name ,
            ],
            'token' => $token,
        
        ])->cookie($cookie);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $cookie = Cookie::forget('auth_token');

        return response()->json(['message' => 'Logged out successfully'])->withCookie($cookie);
    }
    
    public function profile(Request $request)
    {
        $user= $request->user();
        return response()->json(new UserResource($user));
    }

    

}
