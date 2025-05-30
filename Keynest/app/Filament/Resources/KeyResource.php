<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\KeyResource\Pages;
use App\Filament\Resources\KeyResource\RelationManagers;
use App\Models\Key;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeyResource extends Resource
{
    protected static ?string $model = Key::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $slug = 'keys';

    public static function getModelLabel(): string
    {
        return 'Key';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Keys';
    }

    public static function getForm():array
    {
        return[
                Select::make('game_id')
                    ->label('Juego')
                    ->relationship('game','title'),

                TextInput::make('key')->required(),
                Toggle::make('used'),

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
                TextColumn::make('game.title')
                    ->label('Juego'),
                TextColumn::make('key'),
                ToggleColumn::make('used')
                    ->label('Usado')
                    ->disabled(),


            ])
            ->filters([

            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListKeys::route('/'),
            'create' => Pages\CreateKey::route('/create'),
            'edit' => Pages\EditKey::route('/{record}/edit'),
        ];
    }
}
