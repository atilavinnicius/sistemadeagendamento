<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceSchenduleRequest extends FormRequest
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
            'date_time' => 'required|date',
            'client_id' => 'required|exists:users,id',
            'status' => ['required', Rule::in(['aguardando_aceitacao', 'rejeitado', 'cancelado', 'aceito', 'concluido'])],
            'service_id' => 'required|exists:services,id',
        ];
    }

    public function messages()
    {
        return [
            'date_time.required' => 'A data e hora do agendamento são obrigatórias.',
            'date_time.date' => 'A data e hora do agendamento devem ser válidas.',
            'client_id.required' => 'O ID do cliente é obrigatório.',
            'client_id.exists' => 'O cliente selecionado não existe.',
            'status.required' => 'O status do agendamento é obrigatório.',
            'status.in' => 'O status do agendamento deve ser um dos seguintes valores: aguardando_aceitacao, rejeitado, cancelado, aceito.',
            'service_id.required' => 'O ID do serviço é obrigatório.',
            'service_id.exists' => 'O serviço selecionado não existe.',
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
