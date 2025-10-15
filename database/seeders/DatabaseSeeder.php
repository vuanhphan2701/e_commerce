<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Database\Seeders\RolePermissionSeeder;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([RolePermissionSeeder::class]);
    }
}
