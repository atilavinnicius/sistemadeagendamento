<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService as ServicesUserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();

            $userData = $request->validated();

            // Salvar usuário
            $user = $this->userService->createUser($userData);
            $userId = $user->id;

            // Salvar endereço do usuário
            $addressData = $request->only(['address', 'number', 'neighborhood', 'complement' ,'city', 'state', 'zip_code']);
            $addressData['user_id'] = $userId;

            $this->userService->createAddress($addressData);

            // Salvar telefone do usuário
            $telephoneData = $request->only(['telephone']);
            $telephoneData['user_id'] = $userId;
            $this->userService->createTelephone($telephoneData);

            // Processar o upload da foto de perfil
            $file = $request->file('profile_photo');
            $path = $file->store('profile_photos', 'public');

            // Adicionar o user_id e o path aos dados da foto de perfil
            $profilePhotoData = ['user_id' => $userId, 'path' => $path];
            $this->userService->saveProfilePhoto($profilePhotoData);


            DB::commit();
            return response()->json($user, 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao salvar dados.','erro' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
