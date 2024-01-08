<?php

namespace Database\Seeders;

use App\Models\ContractOffer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ContractOfferSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;


    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $token = Str::random(32);
        $contract_offer = [];
        $dad_percent = $this->faker->numberBetween(1, 100);
        for ($i = 1; $i < 10; $i++) {
            $contract_offer[] = [
                'id'                => $i,
                'dad_id'            => $this->faker->numberBetween(1, 10),
                'artist_id'         => $this->faker->numberBetween(1, 10),
                'email'             => $this->faker->email,
                'date_start'        => Carbon::now()->format('Y-m-d H:i:s'),
                'date_end'          => Carbon::now()->format('Y-m-d H:i:s'),
                'token'             => $token,
                'selling_price'     => $this->faker->numberBetween(1000, 10000),
                'dad_percent'       => $dad_percent,
                'artist_percent'    => 100 - $dad_percent,
                'dad_price'         => $this->faker->randomFloat(2, 1, 100),
                'artist_price'      => $this->faker->randomFloat(2, 1, 100),
                'system_price'      => $this->faker->randomFloat(2, 1, 100),
                'opensea_price'     => $this->faker->randomFloat(2, 1, 100),
                'system_percent'    => $this->faker->numberBetween(1, 99),
                'opensea_percent'   => $this->faker->numberBetween(1, 99),
                'responsibility'    => Str::random(16),
                'contact_info'      => Str::random(16),
                'status'            => $this->faker->numberBetween(0, 4),
                'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        ContractOffer::insert($contract_offer);
    }
}
