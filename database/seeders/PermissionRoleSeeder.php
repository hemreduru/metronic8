<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create only dashboard permission
        Permission::create([
            'name' => 'dashboard',
            'guard_name' => 'web',
            'description' => 'Dashboard Erişimi',
            'sort_order' => 1,
        ]);

        // Create only 2 roles: software and normal user
        $softwareRole = Role::create(['name' => 'software', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'normal user', 'guard_name' => 'web']);

        // Both roles get dashboard access
        $dashboardPermission = Permission::where('name', 'dashboard')->first();
        $softwareRole->syncPermissions([$dashboardPermission]);
        $userRole->syncPermissions([$dashboardPermission]);

        // Create 2 test users
        $softwareUser = User::create([
            'name' => 'Software User',
            'email' => 'software@test.com',
            'password' => bcrypt('password'),
        ]);

        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        // Assign roles
        $softwareUser->assignRole('software');
        $normalUser->assignRole('normal user');
    }
}
