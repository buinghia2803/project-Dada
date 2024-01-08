<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ['index', 'store', 'show', 'update', 'destroy', 'getProfile', 'uploadFileLocal', 'uploadFileS3'];

        $prefix = strtolower(class_basename(User::class));

        foreach ($actions as $key) {
            Permission::create(['name' => $prefix . '.' . $key]);
        }

        $user = User::updateOrCreate(['first_name' => 'Admin'], [
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@admin.com',
            'address_contract' => 'Abcd1234',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        $user->syncRoles(config('constant.admin_role'));
    }
}
