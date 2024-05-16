<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create([
                    'role' => \App\Enums\RolesEnum::CLIENT // Define o papel como cliente
                ])->id;
            },
            'zip_code' => $this->faker->postcode,
            'address' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'complement' => $this->faker->secondaryAddress,
        ];
    }
}
