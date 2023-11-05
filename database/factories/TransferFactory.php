<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => $this->faker->randomNumber(1, 100),
            'user_id' => $this->faker->randomNumber(1, 100),
            'date' => $this->faker->dateTime(),
            'transfer_amount' => $this->faker->randomFloat(2, 100, 1000),
            'attachment' => $this->faker->text,
        ];
    }
}
