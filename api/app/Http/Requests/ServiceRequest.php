<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceRequest extends FormRequest
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
        $rules = [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];
        if ($this->isMethod('post')) {
            $rules['photos'] = 'required|array|min:1';
            $rules['photos.*'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $rules['perfil_photo'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.exists' => 'O ID do usuário deve existir na tabela de usuários.',
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'title.max' => 'O título não pode exceder 255 caracteres.',
            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser um texto.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser pelo menos 0.',
            'photos.required' => 'Pelo menos uma imagem de demonstração é obrigatória.',
            'photos.array' => 'As imagens de demonstração devem estar em um array.',
            'photos.min' => 'Você deve fornecer pelo menos uma imagem de demonstração.',
            'photos.*.image' => 'Cada arquivo deve ser uma imagem.',
            'photos.*.mimes' => 'Cada imagem deve ser dos tipos: jpeg, png, jpg',
            'photos.*.max' => 'Cada imagem não pode exceder 2MB.',
            'perfil_photo.required' => 'A foto de perfil é obrigatória.',
            'perfil_photo.image' => 'O arquivo deve ser uma imagem.',
            'perfil_photo.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif, svg.',
            'perfil_photo.max' => 'A imagem não pode exceder 2MB.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'Erro na validação dos campos' => '',
            'errors' => $validator->errors()
        ], 422));
    }
}
