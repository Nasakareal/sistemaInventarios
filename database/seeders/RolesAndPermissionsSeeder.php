<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Todos los permisos (incluyendo los nuevos relacionados con requisiciones)
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
        ];

        // Crear permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Definición de roles y permisos asignados
        $roles = [
            'Administrador' => $permissions, // Acceso completo
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
                'ver usuarios',
                'ver requisiciones',
                'ver requisiciones por cuenta',
            ],
            'Observador' => [
                'ver configuraciones',
                'ver requisiciones',
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
