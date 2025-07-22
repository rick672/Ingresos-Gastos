<?php

namespace App\Filament\Resources\PersonaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestamosRelationManager extends RelationManager
{
    protected static string $relationship = 'prestamos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)
                    ->schema([
                        Forms\Components\TextInput::make('monto')
                            ->label('Monto')
                            ->step(0.01)
                            ->prefix('Bs.')
                            ->required()
                            ->columnSpan(3)
                            ->numeric(),
                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha del prestamo')
                            ->maxDate(now())
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\RichEditor::make('descripcion')
                            ->label('Descripción')
                            ->toolbarButtons(['bold', 'italic', 'bulletList'])
                            ->columnSpan(6)
                            ->required(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('descripcion')
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Motivo del prestamo')
                    ->html(),
                Tables\Columns\TextColumn::make('monto')
                    ->label('Dinero Prestado')
                    ->numeric()
                    ->prefix('Bs. '),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha del prestamo')
                    ->searchable()
                    ->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nuevo Prestamo')
                    ->icon('heroicon-o-plus')
                    ->modalWidth('xl'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->modalWidth('xl'),
                Tables\Actions\DeleteAction::make()
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
