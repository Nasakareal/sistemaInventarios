<?php

namespace App\Imports;

use App\Models\Producto;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductosImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $depreciacion = !empty($row['vida_util'])
            ? ($row['precio_compra'] / $row['vida_util'])
            : null;

        return new Producto([
            'codigo'                         => $row['codigo'],
            'nombre'                         => $row['nombre'],
            'descripcion'                    => $row['descripcion'],
            'categoria_id'                   => $row['categoria_id'],
            'proveedor_id'                   => $row['proveedor_id'],
            'marca'                          => $row['marca'],
            'modelo'                         => $row['modelo'],
            'serie'                          => $row['serie'],
            'departamento_id'                => $row['departamento_id'],
            'precio_compra'                  => $row['precio_compra'],
            'ubicacion'                      => $row['ubicacion'],
            'estado'                         => $row['estado'],
            'area'                           => $row['area'],
            'ur'                             => $row['ur'],
            'partida'                        => $row['partida'],
            'numero_inventario_patrimonial'  => $row['numero_inventario_patrimonial'],
            'numero_inventario_saacg'        => $row['numero_inventario_saacg'],
            'vida_util'                      => $row['vida_util'],
            'depreciacion_anual'             => $depreciacion,
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo'         => 'required|string|max:50|unique:productos,codigo',
            'nombre'         => 'required|string|max:150',
            'categoria_id'   => 'required|exists:categorias,id',
            'proveedor_id'   => 'nullable|exists:proveedores,id',
            'precio_compra'  => 'nullable|numeric|min:0',
            'estado'         => ['required', Rule::in(['ACTIVO','INACTIVO'])],
            'vida_util'      => 'nullable|integer|min:1',
        ];
    }
}
