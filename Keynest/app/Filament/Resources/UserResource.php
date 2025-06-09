<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    //protected static ?string $navigationLabel = 'DOCUMENTACIONES';
    protected static ?string $slug = 'usuarios';

    public static function getModelLabel(): string
    {
        return 'Usuario';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Usuarios';
    }
    public static function shouldRegisterNavigation(): bool
        {
            $user = Auth::user();
            $id=$user->roles->first()->id;
            if($id==1){
                return true;
            }else{
                return false;
            }
        }
    public static function getForm():array
    {
        return [
                Select::make('type')
                    ->label('Tipo Usuario')
                    ->options([
                        'user'=>'Usuario',
                        'company'=>'Empresa'
                    ])
                    ->reactive()
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('surname')
                    ->label('Apellido')
                    ->visible(fn (Get $get) => $get('type') === 'user'),
                TextInput::make('nickname')
                    ->visible(fn (Get $get) => $get('type') === 'user'),
                Select::make('plan')
                    ->visible(fn (Get $get) => $get('type') === 'company')
                    ->options([
                        'free'=>'Free',
                        'pro'=>'Pro',
                        'team'=>'Team'
                    ])
                    ->default('free'),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password(),
                    ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('surname')
                    ->label('Apellido')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->label('Email Verificado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
                    ->label('Tipo de usuario')
                    ->formatStateUsing(function ($state) {
                        return [
                            'user' => 'Usuario',
                            'company' => 'Empresa',
                        ][$state] ?? $state;
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('verified')
                    ->label('verificado')
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(function ($record){
                        $record->roles()->detach();
                    })
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
