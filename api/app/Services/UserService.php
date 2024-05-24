<?php
namespace App\Services;

use App\Models\Address;
use App\Models\ProfilePhoto;
use App\Models\Telephone;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $userData): User
    {
        $userData['password'] = Hash::make($userData['password']);
        return User::create($userData);
    }

    public function getAllUsers()
    {
        return User::with(['address', 'telephones', 'profilePhoto'])->get();
    }

    public function getUserById($id): ?User
    {
        return User::with(['address', 'telephones', 'profilePhoto'])->find($id);
    }

    public function updateUser($id, array $userData): ?User
    {
        $user = User::find($id);
        if (!$user) {
            throw new Exception('User not found.');
        }

        if (isset($userData['password'])) {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user->update($userData);
        return $user;
    }

    public function deleteUser($id): void
    {
        $user = User::find($id);
        if (!$user) {
            throw new Exception('User not found.');
        }
        $user->delete();
    }

    public function createAddress(array $addressData): Address
    {
        return Address::create($addressData);
    }

    public function updateAddress($userId, array $addressData): Address
    {
        $address = Address::where('user_id', $userId)->first();
        if (!$address) {
            throw new Exception('Address not found.');
        }
        $address->update($addressData);
        return $address;
    }

    public function createTelephones(array $telephonesData, int $userId): void
    {
        foreach ($telephonesData as $telephone) {
            if (!is_array($telephone)) {
                Telephone::create([
                    'user_id' => $userId,
                    'telephone' => $telephone,
                ]);
            }
        }
    }

    public function updateTelephones(array $telephonesData, int $userId): void
    {
        $existingIds = Telephone::where('user_id', $userId)->pluck('id')->toArray();

        foreach ($telephonesData as $telephoneData) {
            // Verifica se $telephoneData é um array
            if (is_array($telephoneData)) {
                if (isset($telephoneData['id']) && in_array($telephoneData['id'], $existingIds)) {
                    $telephone = Telephone::find($telephoneData['id']);
                    $telephone->update([
                        'telephone' => $telephoneData['telephone']
                    ]);
                    $existingIds = array_diff($existingIds, [$telephoneData['id']]);
                } else {
                    $telephoneData['user_id'] = $userId;
                    Telephone::create([
                        'user_id' => $userId,
                        'telephone' => $telephoneData['telephone'],
                    ]);
                }
            }
        }

        if (!empty($existingIds)) {
            Telephone::whereIn('id', $existingIds)->delete();
        }
    }

    public function saveProfilePhoto(array $profilePhotoData): ProfilePhoto
    {
        return ProfilePhoto::create($profilePhotoData);
    }

    public function updateProfilePhoto($userId, array $profilePhotoData): ProfilePhoto
    {
        $profilePhoto = ProfilePhoto::where('user_id', $userId)->first();
        if ($profilePhoto) {
            $profilePhoto->update($profilePhotoData);
        } else {
            $profilePhoto = $this->saveProfilePhoto($profilePhotoData);
        }
        return $profilePhoto;
    }
}
