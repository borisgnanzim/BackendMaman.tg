<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommandeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Autoriser uniquement les utilisateurs authentifiés
        return Auth::check();
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
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'montant' => 'required|numeric',
            'statut' => 'required|string|max:25',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'articles' => 'required|array',
            'articles.*.article_id' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min=1',
        ];
    }
}
