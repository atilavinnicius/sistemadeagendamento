<?php
namespace Database\Factories;

use App\Models\User;
use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminUserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'cpf' => $this->faker->unique()->numerify('###########'), // Gera um CPF aleatório
            'rg' => $this->faker->unique()->numerify('##########'), // Gera um RG aleatório
            'gender' => $this->faker->numberBetween(0, 1), // Gera um número aleatório entre 0 e 1 para representar gênero
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'date_birth' => $this->faker->date(),
            'date_registration' => $this->faker->date(),
            'password' => Hash::make('123456'),
            'role' => RolesEnum::ADMIN,
            'remember_token' => \Str::random(10),
        ];
    }
}
