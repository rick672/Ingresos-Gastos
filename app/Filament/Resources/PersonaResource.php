<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonaResource\Pages;
use App\Filament\Resources\PersonaResource\RelationManagers;
use App\Models\Persona;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonaResource extends Resource
{
    protected static ?string $model = Persona::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de la persona')
                    ->schema([
                        Forms\Components\Grid::make(12)
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre Completo')
                                    ->maxLength(50)
                                    ->columnSpan(4)
                                    ->required()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        // Capitalizar la primera letra de cada palabra
                                        $set('nombre', ucwords(strtolower($state)));
                                    }),
                                Forms\Components\TextInput::make('telefono')
                                    ->label('Telefono / Celular')
                                    ->numeric()
                                    ->maxLength(50)
                                    ->columnSpan(4)
                                    ->required(),
                                Forms\Components\Select::make('tipo')
                                    ->label('Tipo')
                                    ->options([
                                        'amigo' => 'Amigo',
                                        'familiar' => 'Familiar',
                                    ])
                                    ->columnSpan(4)
                                    ->required(),
                            ])
                    ])
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
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre Completo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Numero de Contacto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Relacion'),
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
            RelationManagers\PrestamosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonas::route('/'),
            'create' => Pages\CreatePersona::route('/create'),
            'edit' => Pages\EditPersona::route('/{record}/edit'),
        ];
    }
}
