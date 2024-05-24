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
        $rules = [
            // Validation User
            'name' => 'required|max:255',
            'rg' => 'required|max:20',
            'cpf' => 'required|max:14',
            'gender' => 'required|integer|between:0,1',
            'email' => 'required',
            'date_birth' => 'required|date|before:today',
            'date_registration' => 'required|date|date_equals:today',
            'password' => 'required',
            'role' => 'required|in:' . implode(',', RolesEnum::getValues()),

            //Validation Address
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:2',
            'complement' => 'nullable|string|max:255',

            //Validation Telephones
            'telephones' => 'required|array|min:1',
            'telephones.*' => 'required|string|max:20',

            // Validation Profile Photo
        ];

        if ($this->isMethod('post')) {
            $rules['rg'] .= '|unique:users';
            $rules['cpf'] .= '|unique:users';
            $rules['email'] .= '|unique:users';
            $rules['profile_photo'] = 'required|image|mimes:png|max:2048'; // Adiciona validação para imagem PNG e tamanho máximo de 2MB
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Validation User
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'rg.required' => 'O RG é obrigatório.',
            'rg.max' => 'O RG não pode ter mais que 20 caracteres.',
            'rg.unique' => 'Este RG já está em uso.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.max' => 'O CPF não pode ter mais que 14 caracteres.',
            'cpf.unique' => 'Este CPF já está em uso.',
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
            'state.required' => 'O Estado é obrigatório.',
            'state.string' => 'O Estado deve ser uma string.',
            'state.max' => 'O Estado não pode ter mais que 2 caracteres.',
            'complement.string' => 'O complemento deve ser uma string.',
            'complement.max' => 'O complemento não pode ter mais que 255 caracteres.',

            // Validation Telephones
            'telephones.required' => 'É necessário fornecer pelo menos um telefone.',
            'telephones.array' => 'Os telefones devem estar em um array.',
            'telephones.min' => 'É necessário fornecer pelo menos um telefone.',
            'telephones.*.required' => 'O número do telefone é obrigatório.',
            'telephones.*.string' => 'O número do telefone deve ser uma string.',
            'telephones.*.max' => 'O número do telefone não pode ter mais que 20 caracteres.',

            // Validation Profile Photo
            'profile_photo.required' => 'A foto de perfil é obrigatória.',
            'profile_photo.image' => 'A foto de perfil deve ser uma imagem.',
            'profile_photo.mimes' => 'A foto de perfil deve ser um arquivo do tipo PNG.',
            'profile_photo.max' => 'A foto de perfil não pode ter mais que 2MB.',
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
