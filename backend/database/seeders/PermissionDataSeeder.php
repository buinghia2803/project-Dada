<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\RoleRepository;


class PermissionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', '=', config('constant.admin_role'))->first();
        $adminPermission = Permission::pluck('id');
        $roleRepo = new RoleRepository();
        $roleRepo->syncPermissions($admin, $adminPermission);
    }
}
