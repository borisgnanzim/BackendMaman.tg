<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            // pour article
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mini_description' => 'nullable|string',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            // pour image 
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // pour categorie article 
            'categorie_ids' => 'required|array',
            'categorie_ids.*' => 'integer|exists:categories,id',
        ];
    }
}
