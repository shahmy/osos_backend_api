<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list authors', 'guard_name' => 'api']);
        Permission::create(['name' => 'view authors' , 'guard_name' => 'api']);
        Permission::create(['name' => 'create authors' , 'guard_name' => 'api']);
        Permission::create(['name' => 'update authors' , 'guard_name' => 'api']);
        Permission::create(['name' => 'delete authors' , 'guard_name' => 'api']);

        Permission::create(['name' => 'list books' , 'guard_name' => 'api']);
        Permission::create(['name' => 'view books' , 'guard_name' => 'api']);
        Permission::create(['name' => 'create books' , 'guard_name' => 'api']);
        Permission::create(['name' => 'update books' , 'guard_name' => 'api']);
        Permission::create(['name' => 'delete books', 'guard_name' => 'api']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);
        $userRole->givePermissionTo($currentPermissions);

        // Create author role and assign existing permissions
        $authorRole = Role::create(['name' => 'author', 'guard_name' => 'api']);
        $authorRole->givePermissionTo([
            'list books',
            'view books',
            'create books',
            'update books',
            'delete books',
        ]);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles' , 'guard_name' => 'api']);
        Permission::create(['name' => 'view roles' , 'guard_name' => 'api']);
        Permission::create(['name' => 'create roles', 'guard_name' => 'api']);
        Permission::create(['name' => 'update roles' , 'guard_name' => 'api']);
        Permission::create(['name' => 'delete roles' , 'guard_name' => 'api']);

        Permission::create(['name' => 'list permissions' , 'guard_name' => 'api']);
        Permission::create(['name' => 'view permissions', 'guard_name' => 'api']);
        Permission::create(['name' => 'create permissions' , 'guard_name' => 'api']);
        Permission::create(['name' => 'update permissions', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete permissions', 'guard_name' => 'api']);

        Permission::create(['name' => 'list users', 'guard_name' => 'api']);
        Permission::create(['name' => 'view users', 'guard_name' => 'api']);
        Permission::create(['name' => 'create users', 'guard_name' => 'api']);
        Permission::create(['name' => 'update users', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'api']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
