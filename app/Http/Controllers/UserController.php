<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\JsonResponseTrait;



/**
 * @group User Management
 * 
 * APIs to manage the User ressource
 **/
class UserController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->paginate(20) ;
        return $this-> sucessResponseWithPaginate(UserResource::class, $users, 'users') ;
    }

    public function store(StoreUserRequest $request)
    {
        //$validatedData = $request->except(["password"]);
        //$validatedData['password'] = Hash::make($request->input("password"));
       // $user = User::create( array_merge($request->except(["password"]) , ["password" =>Hash::make($request->input("password"))]));

        return $this->successResponse(new UserResource(User::create( $request->all() )), 'User created successfully', 201);
    }

    public function show($id)
    {
        $user =User::find($id);
        if ($user==null)
        {
            return $this-> errorResponse("User not found");
        }
        return $this->successResponse(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validatedData = $request->validated();
        // if (isset($validatedData['password'])) {
        //     $validatedData['password'] = Hash::make($validatedData['password']);
        // }
        //$user->update($request->all());
       // return $request->all() ;
        $user =User::find($id);
        if ($user == null)
        {
            return $this->errorResponse("User not found");
        }
        //$user->update($request->except(['password']));
        $user->update($validatedData);

        return $this->successResponse(new UserResource($user), 'User updated successfully');
    }

    public function destroy($id)
    {
        $user =User::find($id);
        if ($user==null)
        {
            return $this-> errorResponse("User not found");
        }
        $user->delete();
        return $this->successResponse(null, 'User deleted successfully', 204);
    }
}
