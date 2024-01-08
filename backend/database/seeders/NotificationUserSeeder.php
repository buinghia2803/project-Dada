<?php

namespace Database\Seeders;

use App\Models\NotificationUser;
use Illuminate\Database\Seeder;

class NotificationUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationUser::factory(10)->create();
    }
}
