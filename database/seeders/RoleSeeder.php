<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view employees',
            'create employee',
            'edit employee',
            'delete employee',
            'view departments',
            'manage departments',
            'approve leave',
            'apply leave',
            'view reports',
            'export data',
            'view own profile',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $hrAdmin = Role::create(['name' => 'hr_admin']);
        $hrAdmin->givePermissionTo($permissions);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view employees',
            'view departments',
            'approve leave',
            'apply leave',
            'view own profile',
        ]);

        $employee = Role::create(['name' => 'employee']);
        $employee->givePermissionTo([
            'apply leave',
            'view own profile',
        ]);

        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo($permissions);
    }
}