<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLivraisonRequest extends FormRequest
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
            'titre' => 'nullable|string|max:255',
            //'date' => 'nullable|date',
            'nomClient' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            'adresse' => 'required|string|max:255',
            'destinataire' => 'required|string|max:10',
            'commande_id' => 'required|exists:commandes,id'
        ];
    }
}
