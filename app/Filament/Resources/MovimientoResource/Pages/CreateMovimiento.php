<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use App\Models\Categoria;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();

        // Si no se subió una imagen, definimos una por defecto según el tipo
        if (empty($data['foto'])) {
            // Obtener el tipo de categoría
            $categoria = Categoria::find($data['categoria_id']);
            $tipo = $categoria?->tipo;

            if ($tipo === 'ingreso') {
                $this->form->fill([
                    'foto' => 'movimientos/default_ingreso.png',
                ]);
            } elseif ($tipo === 'gasto') {
                $this->form->fill([
                    'foto' => 'movimientos/default_gasto.png',
                ]);
            }
        }
    }

}
