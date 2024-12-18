<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Roles y Permisos';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Correo Electronico')
                    ->email()
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label('Contraseña')
                    //oculta el campo al editar
                    ->hiddenOn('edit')
                    ->password()
                    ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->dehydrated(fn ($state) => filled ($state))
                    //nos ayuda en encriptar la contarseña
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                TextInput::make('passwordConfirmation')
                    ->label('Confirmar Contraseña')
                    ->hiddenOn('edit')
                    ->password()
                    ->required(fn (Page $livewire): bool => $livewire instanceof
                        CreateRecord)
                    ->minLength(8)
                    ->dehydrated(false)
                    ,
                Select::make('roles')->multiple()->relationship('roles','name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo Electronico')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->label('Correo Verificado')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                textColumn::make('roles.name'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
           
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
