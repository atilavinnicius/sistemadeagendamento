<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar usuários.'], 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $user = $this->userService->createUser($userData);
            $userId = $user->id;

            $addressData = $request->only(['address', 'number', 'neighborhood', 'complement', 'city', 'state', 'zip_code']);
            $addressData['user_id'] = $userId;
            $this->userService->createAddress($addressData);

            $telephoneData = $request->input('telephones', []);
            $this->userService->createTelephones($telephoneData, $userId);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $path = $file->store('public/users/perfil');
                $profilePhotoData = ['user_id' => $userId, 'path' => $path];
                $this->userService->saveProfilePhoto($profilePhotoData);
            }

            DB::commit();
            return response()->json($user, 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao salvar dados.', 'details' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar usuário.'], 500);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $user = $this->userService->updateUser($id, $userData);

            $addressData = $request->only(['address', 'number', 'neighborhood', 'complement', 'city', 'state', 'zip_code']);
            $this->userService->updateAddress($id, $addressData);

            $telephoneData = $request->input('telephones', []);
            $this->userService->updateTelephones($telephoneData, $id);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $path = $file->store('public/users/perfil');
                $profilePhotoData = ['user_id' => $id, 'path' => $path];
                $this->userService->updateProfilePhoto($id, $profilePhotoData);
            }

            DB::commit();
            return response()->json($user);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao atualizar dados.', 'details' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->userService->deleteUser($id);
            DB::commit();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao excluir usuário.', 'details' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
