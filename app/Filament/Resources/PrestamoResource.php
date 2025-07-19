<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestamoResource\Pages;
use App\Filament\Resources\PrestamoResource\RelationManagers;
use App\Models\Prestamo;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestamoResource extends Resource
{
    protected static ?string $model = Prestamo::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del prestamo')
                    ->schema([
                        Forms\Components\Grid::make(6)
                            ->schema([
                                Forms\Components\Select::make('persona_id')
                                    ->label('Nombre de la persona')
                                    ->relationship('persona', 'nombre')
                                    ->columnSpan(2)
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\Grid::make(6)
                                            ->schema([
                                                Forms\Components\TextInput::make('nombre')
                                                    ->label('Nombre Completo')
                                                    ->columnSpanFull()
                                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                                            // Capitalizar la primera letra de cada palabra
                                                            $set('nombre', ucwords(strtolower($state)));
                                                        })
                                                    ->required(),
                                                Forms\Components\TextInput::make('telefono')
                                                    ->label('Telefono')
                                                    ->columnSpan(3)
                                                    ->required(),
                                                Forms\Components\Select::make('tipo')
                                                    ->label('Tipo')
                                                    ->columnSpan(3)
                                                    ->options([
                                                        'amigo' => 'Amigo',
                                                        'familiar' => 'Familiar',
                                                    ])
                                                    ->required(),
                                            ])
                                    ])
                                    ->createOptionAction(
                                        function (\Filament\Forms\Components\Actions\Action $action){
                                            return $action
                                                ->modalHeading('Nueva Persona')
                                                ->modalWidth('lg');
                                        }
                                    )
                                    ->required(),
                                Forms\Components\TextInput::make('monto')
                                    ->label('Monto')
                                    ->step(0.01)
                                    ->prefix('Bs.')
                                    ->required()
                                    ->columnSpan(2)
                                    ->numeric(),
                                Forms\Components\DatePicker::make('fecha')
                                    ->label('Fecha del prestamo')
                                    ->maxDate(now())
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\RichEditor::make('descripcion')
                                    ->label('Descripción')
                                    ->toolbarButtons(['bold', 'italic', 'bulletList'])
                                    ->columnSpanFull(),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro.')
                    ->sortable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('persona.nombre')
                    ->label('Nombre de la persona')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto')
                    ->label('Dinero Prestado')
                    ->numeric()
                    ->prefix('Bs. ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha del prestamo')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),
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
            'index' => Pages\ListPrestamos::route('/'),
            'create' => Pages\CreatePrestamo::route('/create'),
            'edit' => Pages\EditPrestamo::route('/{record}/edit'),
        ];
    }
}
