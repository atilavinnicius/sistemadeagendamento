<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService as ServicesUserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(ServicesUserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(UserRequest $request)
    {
        try {
            $userData = $request->validated();

            // Salvar usuário
            $user = $this->userService->createUser($userData);

            // Salvar endereço do usuário
            $addressData = $request->only(['address', 'city', 'state', 'zipcode']);
            $this->userService->createAddress($addressData);

            // Salvar telefone do usuário
            $telephoneData = $request->only(['telephone']);
            $this->userService->createTelephone($telephoneData);

            // Salvar foto do perfil do usuário
            $profilePhotoData = $request->only(['profile_photo']);
            $this->userService->saveProfilePhoto($profilePhotoData);

            return response()->json($user, 201);
        } catch (QueryException $e) {
            // Se ocorrer um erro de consulta, provavelmente devido a restrições de chave estrangeira ou outros problemas de integridade de dados
            return response()->json(['error' => 'Erro ao salvar dados.','erro' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Captura qualquer outra exceção não tratada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
