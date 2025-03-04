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

            // Proveedores
            'ver proveedores',
            'crear proveedores',
            'editar proveedores',
            'eliminar proveedores',

            // Cuentas
            'ver cuentas',
            'crear cuentas',
            'editar cuentas',
            'eliminar cuentas',

            // Categorias
            'ver categorias',
            'crear categorias',
            'editar categorias',
            'eliminar categorias',

            // Bajas
            'ver bajas',
            'crear bajas',
            'editar bajas',
            'eliminar bajas',

            // Servicios
            'ver servicios',
            'crear servicios',
            'editar servicios',
            'eliminar servicios',

            // Almacen
            'ver almacenes',
            'crear almacenes',
            'editar almacenes',
            'eliminar almacenes',

            // Actividades
            'ver actividades',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
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
                'ver categorias',
                'crear categorias',
                'editar categorias',
                'eliminar categorias',
            ],
            'Empleado' => [
                'ver requisiciones',
                'ver requisiciones por cuenta',
                'ver productos',
                'ver proveedores',
            ],
            'Observador' => [
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
