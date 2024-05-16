<?php

namespace Database\Factories;

use App\Models\Telephone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Telephone>
 */
class ClientTelephoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Telephone::class;

    public function definition(): array
    {
        return [
            'user_id' => 2,
            'telephone' => '8498100-5888',
        ];
    }
}
