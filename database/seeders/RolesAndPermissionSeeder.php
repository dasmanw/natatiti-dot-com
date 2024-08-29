<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // roles
        $arrayOfRoleNames = User::$roles;
        $roles = collect($arrayOfRoleNames)->map(function ($role) {
            return ['name' => $role, 'guard_name' => 'web'];
        });

        Role::insert($roles->toArray());

        // permissions
        $arrayOfPermissionNames = [
            'vendor.*',
            'salesman.*',
            'product.*',
            'category.*',
            'reservation.*',
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        // give permissions to roles
        Role::where('name', User::ADMIN)->first()->givePermissionTo(['vendor.*', 'product.*', 'salesman.*', 'category.*', 'reservation.*']);
        Role::where('name', User::VENDOR)->first()->givePermissionTo(['product.*']);
        Role::where('name', User::SALESMAN)->first()->givePermissionTo(['reservation.*']);
    }
}
