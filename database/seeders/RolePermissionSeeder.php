<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1️Danh sách quyền
        $permissions = [
            'create_product',
            'update_product',
            'delete_product',
            'view_product',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 2️ Danh sách vai trò
        $roles = ['admin', 'manager', 'staff'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 3️ Gán quyền cho role
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $staffRole = Role::where('name', 'staff')->first();

        $adminRole->permissions()->sync(Permission::all()->pluck('id'));
        $managerRole->permissions()->sync(
            Permission::whereIn('name', ['create_product', 'update_product', 'view_product'])->pluck('id')
        );
        $staffRole->permissions()->sync(
            Permission::whereIn('name', ['view_product'])->pluck('id')
        );

        // 4️ Tạo user demo
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('123456')]
        );

        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            ['name' => 'Manager', 'password' => Hash::make('123456')]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Staff', 'password' => Hash::make('123456')]
        );

        // 5️ Gán role cho user
        $admin->roles()->sync([$adminRole->id]);
        $manager->roles()->sync([$managerRole->id]);
        $staff->roles()->sync([$staffRole->id]);

        $this->command->info('Role & Permission demo seeded successfully!');
    }
}
