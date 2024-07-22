<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $user = Auth::user();
        // return $user && $user->role->name =='admin' ;
        return Auth::check() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array  
    {
        return [
            //
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email',
            'adresse' => 'nullable|string|max:255',
            //'coordonne_geographique' => 'nullable|string|max:255',
            'telephone' => 'sometimes|required|string|max:255|unique:users,telephone',
            'role_id' => 'nullable|integer|max:25|exists:roles,id',
            'name' => 'sometimes|required|string|max:255|unique:users,name',
            //'password' => 'nullable|string|min:8|confirmed'
        ];
    }
}
