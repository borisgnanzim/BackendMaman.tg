<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UpdateLivraisonRequest extends FormRequest
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
            // 'titre' => 'string|max:255',
            // //'date' => 'sometimes|required|date',
            // 'nomClient' => 'nullable|string|max:255',
            // 'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            // 'adresse' => 'string|max:255',
            // 'destinataire' => 'nullable|string|max:10',
            // 'commande_id' => 'exists:commandes,id'

            'titre' => 'nullable|string|max:255',
            //'date' => 'nullable|date',
            'nomClient' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            'adresse' => 'nullable|string|max:255',
            'destinataire' => 'nullable|string|max:10',
            'commande_id' => 'nullable|exists:commandes,id'
        ];
    }
}
