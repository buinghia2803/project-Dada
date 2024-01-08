<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'content' => $this->faker->text,
            'action' => $this->faker->text,
            'type' => $this->faker->numberBetween(0, 3),
            'sender_type' => $this->faker->numberBetween(0, 3),
            'date_public' => Carbon::now()->format('Y-m-d'),
        ];
    }
}
