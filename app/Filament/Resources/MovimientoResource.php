<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoResource\Pages;
use App\Filament\Resources\MovimientoResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Movimiento;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Finanzas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informacion del movimiento')
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                Forms\Components\Select::make('categoria_id')
                                    ->label('Categoria')
                                    ->relationship('categoria', 'nombre')
                                    ->columnSpan(4)
                                    ->required()
                                    ->live() // <- importante para que detecte cambios en tiempo real
                                    ->searchable()  // Asegúrate de que esté habilitado
                                    ->preload()     // Precarga las opciones
                                    ->afterStateUpdated(
                                            function (Forms\Set $set, $state) {
                                                // set establece el valor de tipo_categoria y state agarra el id de el select actual
                                                $categoria = Categoria::find($state);
                                                $set('tipo_categoria', $categoria?->tipo ?? null);
                                            }
                                        )
                                    ->afterStateHydrated(
                                            function (Forms\Set $set, $state) {
                                                $categoria = \App\Models\Categoria::find($state);
                                                $set('tipo_categoria', $categoria?->tipo ?? null);
                                            }
                                        )
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre')
                                            ->label('Nombre de la categoria')
                                            ->required()
                                            ->maxLength(50),
                                        Forms\Components\Select::make('tipo')
                                            ->label('Tipo de la categoria')
                                            ->options([
                                                'gasto' => 'Gasto',
                                                'ingreso' => 'Ingreso',
                                            ])
                                            ->required()
                                        ])
                                     ->createOptionUsing(function (array $data, Forms\Set $set): int {
                                            // 1. Crear la nueva categoría
                                            $categoria = Categoria::create([
                                                'nombre' => $data['nombre'],
                                                'tipo' => $data['tipo'],
                                            ]);

                                            // 2. Forzar la actualización del Select (nuevo en Filament v3)
                                            $set('categoria_id', $categoria->id); // <- Esto es clave

                                            // 3. Retornar el ID para que el Select lo use
                                            return $categoria->id;
                                        })
                                    ->createOptionAction(
                                        function (\Filament\Forms\Components\Actions\Action $action){
                                            return $action
                                                ->modalHeading('Nueva Categoria')
                                                ->modalWidth('lg');
                                        }
                                    ),
                                Forms\Components\TextInput::make('tipo_categoria')
                                    ->label('Tipo')
                                    ->disabled()
                                    ->columnSpan(2)
                                    ->dehydrated(false), // <- importante: evita que se guarde en la DB
                                Forms\Components\TextInput::make('monto')
                                    ->label('Monto')
                                    ->step(0.01)
                                    ->prefix('Bs. ')
                                    ->required()
                                    ->columnSpan(3)
                                    ->numeric(),
                                Forms\Components\DatePicker::make('fecha')
                                    ->label('Fecha del Movimiento')
                                    ->maxDate(now())
                                    ->columnSpan(3)
                                    ->required(),
                                Forms\Components\Textarea::make('descripcion')
                                    ->label('Descripcion')
                                    ->columnSpan(6),
                                Forms\Components\FileUpload::make('foto')
                                    ->columnSpan(6)
                                    ->disk('public')
                                    ->directory('movimientos')
                                    ->image()
                                    ->imageEditor(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('Nro.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Nombre Categoria')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha del Movimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto')
                    ->label('Monto')
                    ->prefix('Bs. ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->width(100)
                    ->height(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimientos::route('/'),
            'create' => Pages\CreateMovimiento::route('/create'),
            'edit' => Pages\EditMovimiento::route('/{record}/edit'),
        ];
    }
}
