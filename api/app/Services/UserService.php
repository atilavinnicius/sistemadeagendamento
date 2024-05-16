<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Profile_photo;
use App\Models\Telephone;
use App\Models\User;

class UserService
{

    public function createUser(array $userData): User
    {
        return User::create($userData);
    }

    public function createAddress(array $addresData): Address
    {
        return Address::create($addresData);

    }
    public function createTelephone(array $telephoneData): Telephone
    {
        return Telephone::create($telephoneData);
    }
    public function saveProfilePhoto(array $profilephotoData): Profile_photo
    {
        return Profile_photo::create($profilephotoData);
    }
}
