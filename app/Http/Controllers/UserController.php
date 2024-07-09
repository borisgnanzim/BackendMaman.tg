<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\JsonResponseTrait;

class UserController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        $users = User::with('role')->get();
        return $this->successResponse(UserResource::collection($users));
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        return $this->successResponse(new UserResource($user), 'User created successfully', 201);
    }

    public function show(User $user)
    {
        return $this->successResponse(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $user->update($validatedData);
        return $this->successResponse(new UserResource($user), 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse(null, 'User deleted successfully', 204);
    }
}
