<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCommandeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Obtenir l'utilisateur authentifié
        $user = Auth::user();

        // Obtenir la commande en cours de mise à jour
        $commande = $this->route('commande');

        // Autoriser seulement si l'utilisateur est authentifié et est le propriétaire de la commande
        return $user && $commande && $commande->user_id == $user->id;
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
            'titre' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'montant' => 'sometimes|required|numeric',
            'statut' => 'sometimes|required|string|max:255',
            'reference' => 'sometimes|required|string|max:255',
        ];
    }
}
