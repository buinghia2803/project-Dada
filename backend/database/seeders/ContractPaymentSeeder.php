<?php

namespace Database\Seeders;

use App\Models\ContractPayment;
use Illuminate\Database\Seeder;
class ContractPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractPayment::factory(10)->create();
    }
}
