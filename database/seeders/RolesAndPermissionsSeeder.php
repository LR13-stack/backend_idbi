<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $sellerRole = Role::create(['name' => 'Vendedor']);

        // Permissions
        Permission::create(['name' => 'gestionar usuarios']);
        Permission::create(['name' => 'gestionar clientes']);
        Permission::create(['name' => 'gestionar productos']);
        Permission::create(['name' => 'gestionar ventas']);

        $adminRole->givePermissionTo([
            'gestionar usuarios',
            'gestionar clientes',
            'gestionar productos',
            'gestionar ventas',
        ]);

        $sellerRole->givePermissionTo([
            'gestionar productos',
            'gestionar ventas',
        ]);

        $admin = User::find(1);
        $admin->assignRole('Administrador');

        $seller = User::find(2);
        $seller->assignRole('Vendedor');
    }
}
