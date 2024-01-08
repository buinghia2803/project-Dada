<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContractPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at'                    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'                    => Carbon::now()->format('Y-m-d H:i:s'),
            'contract_offer_id'             => $this->faker->numberBetween(1, 10),
            'contract_nft_id'               => $this->faker->numberBetween(1, 10),
            'dad_price'                     => $this->faker->randomFloat(2, 1, 100),
            'artist_price'                  => $this->faker->randomFloat(2, 1, 100),
            'status'                        => $this->faker->numberBetween(0, 1),
        ];
    }
}
