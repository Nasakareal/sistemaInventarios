<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Configuraciones y usuarios
            'ver configuraciones',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Roles
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Requisiciones
            'ver requisiciones',
            'crear requisiciones',
            'editar requisiciones',
            'eliminar requisiciones',
            'ver requisiciones por cuenta',

            // Productos
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos',
        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Definición de roles y permisos asignados
        $roles = [
            'Administrador' => $permissions,
            'Subdirector' => [
                'ver configuraciones',
                'ver usuarios',
                'ver roles',
                'ver requisiciones',
                'crear requisiciones',
                'editar requisiciones',
                'eliminar requisiciones',
                'ver requisiciones por cuenta',
            ],
            'Empleado' => [
                'ver requisiciones',
                'ver requisiciones por cuenta',
                'ver productos',
            ],
            'Observador' => [
                'ver configuraciones',
                'ver requisiciones',
                'ver productos',
            ],
        ];

        // Crear roles y asignar permisos
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Obtener permisos y sincronizarlos con el rol
            $permissionsToAssign = Permission::whereIn('name', $rolePermissions)->get();
            $role->syncPermissions($permissionsToAssign);
        }
    }
}
