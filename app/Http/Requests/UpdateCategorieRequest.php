<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UpdateCategorieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user && $user->role->name =='admin' ;
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
            'description' => 'nullable|string',
            'superCategorie_id' => 'nullable|exists:categories,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max' => 'Le champ nom ne peut pas dépasser 255 caractères.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'superCategorie_id.exists' => 'La super-catégorie sélectionnée n\'existe pas.'
        ];
    }
}
