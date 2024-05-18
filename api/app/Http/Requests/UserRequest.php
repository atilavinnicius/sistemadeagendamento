<?php

namespace App\Http\Requests;

use App\Enums\RolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        return [
            // Validation User
            'name' => 'required|max:255',
            'rg' => 'required|max:20',
            'cpf' => 'required|max:14',
            'gender' => 'required|integer|between:0,1',
            'email' => 'required|unique:users',
            'date_birth' => 'required|date|before:today',
            'date_registration' => 'required|date|date_equals:today',
            'password' => 'required',
            'role' => 'required|in:' . implode(',', RolesEnum::getValues()),

            //Valitation geral
            'user_id' => 'required|exists:users,id',

            //Validation Address
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'complement' => 'nullable|string|max:255',

            //Validation Telephones
            'telephone' => 'required',

            //Validation Profile Photos
            'path' => 'required|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [
            // Validation User
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'rg.required' => 'O RG é obrigatório.',
            'rg.max' => 'O RG não pode ter mais que 20 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.max' => 'O CPF não pode ter mais que 14 caracteres.',
            'gender.required' => 'O gênero é obrigatório.',
            'gender.integer' => 'O gênero deve ser um número inteiro.',
            'gender.between' => 'O gênero deve ser 0 (masculino) ou 1 (feminino).',
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'O email já está em uso.',
            'date_birth.required' => 'A data de nascimento é obrigatória.',
            'date_birth.date' => 'A data de nascimento deve ser uma data válida.',
            'date_birth.before' => 'A data de nascimento deve ser anterior a hoje.',
            'date_registration.required' => 'A data de registro é obrigatória.',
            'date_registration.date' => 'A data de registro deve ser uma data válida.',
            'date_registration.date_equals' => 'A data de registro deve ser hoje.',
            'password.required' => 'A senha é obrigatória.',
            'role.required' => 'O papel é obrigatório.',
            'role.in' => 'O papel deve ser um dos seguintes valores: admin, client.',



            // Validation geral
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.exists' => 'O ID do usuário fornecido não existe.',

            // Validation Address
            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.string' => 'O CEP deve ser uma string.',
            'zip_code.max' => 'O CEP não pode ter mais que 10 caracteres.',
            'address.required' => 'O endereço é obrigatório.',
            'address.string' => 'O endereço deve ser uma string.',
            'address.max' => 'O endereço não pode ter mais que 255 caracteres.',
            'number.required' => 'O número é obrigatório.',
            'number.string' => 'O número deve ser uma string.',
            'number.max' => 'O número não pode ter mais que 10 caracteres.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.string' => 'O bairro deve ser uma string.',
            'neighborhood.max' => 'O bairro não pode ter mais que 100 caracteres.',
            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser uma string.',
            'city.max' => 'A cidade não pode ter mais que 100 caracteres.',
            'complement.string' => 'O complemento deve ser uma string.',
            'complement.max' => 'O complemento não pode ter mais que 255 caracteres.',

            // Validation Telephones
            'telephone.required' => 'O telefone é obrigatório.',

            // Validation Profile Photos
            'path.required' => 'O caminho do arquivo é obrigatório.',
            'path.string' => 'O caminho do arquivo deve ser uma string.',
            'path.max' => 'O caminho do arquivo não pode ter mais que 255 caracteres.',
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
