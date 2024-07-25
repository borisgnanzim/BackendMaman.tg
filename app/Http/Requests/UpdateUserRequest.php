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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:255',
            'coordonne_geographique' => 'nullable|string|max:255',
            'role_id' => 'nullable|string|max:255|exists:roles,id',
            'name' => 'required|string|max:255|unique:users',
            //'password' => 'required|string|min:8',
        ];
    }
}
