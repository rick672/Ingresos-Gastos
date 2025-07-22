<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use App\Models\Categoria;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovimiento extends EditRecord
{
    protected static string $resource = MovimientoResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['foto'])) {
            $categoria = Categoria::find($data['categoria_id']);
            $tipo = $categoria?->tipo;

            if ($tipo === 'ingreso') {
                $data['foto'] = 'movimientos/default_ingresos.jpg';
            } elseif ($tipo === 'gasto') {
                $data['foto'] = 'movimientos/default_gastos.png';
            }
        }

        return $data;
    }

}
