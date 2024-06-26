<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /* validation des champs suivants */
        return [
            'title' => ['required','string'],
            'content' => ['required','string'],
            /* 'image' => [
                'image', // Le fichier doit être une image
                'mimes:jpeg,jpg,png', // Formats d'image autorisés
                'max:2048', // Taille maximale (en Ko)
            ] */
            
        ];
    }
}
