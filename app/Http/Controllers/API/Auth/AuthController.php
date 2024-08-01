<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    use JsonResponseTrait;

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'role_id' => 2, // Rôle utilisateur par défaut
        ]);

        $token = $user->createToken('auth_token', [$user->role->name ?? ''])->plainTextToken;

        $cookie = cookie('auth_token', $token, 1440, null, null, false, true); // Sécuriser le cookie

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'User registered successfully', 201)->cookie($cookie);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token', [$user->role->name ?? ''])->plainTextToken;

        $cookie = cookie('auth_token', $token, 1440, null, null, false, true); // Sécuriser le cookie

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'User logged in successfully')->cookie($cookie);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $cookie = Cookie::forget('auth_token');

        return $this->successResponse(null, 'Logged out successfully')->withCookie($cookie);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return $this->successResponse(new UserResource($user));
    }
}
