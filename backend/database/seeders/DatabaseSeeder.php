<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        /*$this->call(DataSeeder::class);
        $this->call(ContractOfferSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(ContractPaymentSeeder::class);
        $this->call(NotificationUserSeeder::class);*/
    }
}
