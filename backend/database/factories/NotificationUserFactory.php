<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NotificationUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'notification_id' => $this->faker->numberBetween(1, 10),
            'admin_id' =>$this->faker->numberBetween(0, 3),
            'user_from' =>$this->faker->numberBetween(0, 3),
            'user_to' => $this->faker->numberBetween(0, 3),
            'status' => $this->faker->numberBetween(0, 3),
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ];
    }
}
