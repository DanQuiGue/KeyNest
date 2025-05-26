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
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('game_id'),
                TextInput::make('key')->required(),
                TextInput::make('used'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game_id'),
                TextColumn::make('key'),
                TextColumn::make('used'),

            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListKeys::route('/'),
            'create' => Pages\CreateKey::route('/create'),
            'edit' => Pages\EditKey::route('/{record}/edit'),
        ];
    }
}
