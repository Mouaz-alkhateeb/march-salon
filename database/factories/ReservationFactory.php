<?php

namespace Database\Factories;

use App\Statuses\ReservationStatus;
use App\Statuses\ReservationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
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
            'expert_id' => $this->faker->randomNumber(1, 100),
            'date' => $this->faker->dateTime(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'reservation_number' => $this->faker->unique()->numerify('R#####'),
            'type' => ReservationType::UN_APPROVED,
            'status' => ReservationStatus::PENDING,
            'reservation_amount' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
