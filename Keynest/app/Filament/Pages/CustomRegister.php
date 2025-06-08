<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomRegister extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('Tipo Usuario')
                    ->options([
                        'user'=>'Usuario',
                        'company'=>'Empresa'
                    ])
                    ->live()
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('surname')
                    ->label('Apellido')
                    ->visible(fn (Get $get) => $get('type') === 'user'),
                TextInput::make('nickname')
                    ->visible(fn (Get $get) => $get('type') === 'user'),
                Hidden::make('plan')
                    ->default('free'),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(),
                Hidden::make('verified')
                    ->default(false)
            ]);
    }

     protected function handleRegistration(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $data['type'],
                'plan' => $data['plan'],
                'verified' => $data['verified'],
                'surname' => $data['type'] === 'user' ? $data['surname'] : null,
                'nickname' => $data['type'] === 'user' ? $data['nickname'] : null,
            ]);

            // Asignación de roles con verificación
            $roleId = $data['type'] === 'user' ? 3 : 2;
            $user->roles()->sync([$roleId]);

            return $user;
        });
    }
}
