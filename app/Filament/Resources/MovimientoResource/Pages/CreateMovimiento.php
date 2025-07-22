<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use App\Models\Categoria;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
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

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Registrar'),
            $this->getCancelFormAction()
                ->label('Cancelar'),
        ];
    }


}
