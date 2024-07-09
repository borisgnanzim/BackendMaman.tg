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
            'titre' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'nomClient' => 'sometimes|required|string|max:255',
            'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            'adresse' => 'sometimes|required|string|max:255',
            'destinataire' => 'nullable|string|max:10',
            'commande_id' => 'sometimes|required|exists:commandes,id'
        ];
    }
}
