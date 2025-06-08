<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Filament\Resources\GameResource\RelationManagers\KeysRelationManager;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'juego';

    public static function getModelLabel(): string
    {
        return 'Juego';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Juegos';
    }

    public static function getForm():array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==1){
            return [
                Select::make('company_id')
                    ->label('Compañia')
                    ->relationship('company','name'),
                TextInput::make('title')
                    ->label('Titulo')
                    ->required(),
                Select::make('gender_id')
                    ->label('Genero')
                    ->required()
                    ->relationship('gender','name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(GenderResource::getForm()),
            ];
        }else{
            return [
                Hidden::make('company_id')
                    ->default($user->id),
                TextInput::make('title')
                    ->label('Titulo')
                    ->required(),
                Select::make('gender_id')
                    ->label('Genero')
                    ->required()
                    ->relationship('gender','name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(GenderResource::getForm()),
            ];
        }

    }
    public static function getAction(): array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3){
            return[];
        }else{
            return[
                EditAction::make(),
                DeleteAction::make()
            ];
        }

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
                TextColumn::make('company.name'),
                TextColumn::make('title'),
                TextColumn::make('gender.name'),

            ])
            ->filters([

            ])
            ->actions(self::getAction())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            KeysRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
