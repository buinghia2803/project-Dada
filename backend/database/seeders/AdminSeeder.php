<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
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

        $prefix = strtolower(class_basename(Admin::class));

        foreach ($actions as $key) {
            Permission::create(['name' => $prefix . '.' . $key]);
        }

        $admin = Admin::updateOrCreate(['first_name' => 'Admin'], [
            'first_name' => 'Admin',
            'last_name' => 'System',
            'image_url' => null,
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $admin->syncRoles(config('constant.admin_role'));
    }
}
