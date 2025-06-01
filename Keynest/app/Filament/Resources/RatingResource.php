<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Rating;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'calificacion';

    public static function getModelLabel(): string
    {
        return 'Calificación';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Calificaciones';
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==2 || $id==1){
            return true;
        }else{
            return false;
        }
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('influencer_id'),
                TextInput::make('studio_id'),
                TextInput::make('request_id'),
                TextInput::make('rate'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('influencer_id'),
                TextColumn::make('studio_id'),
                TextColumn::make('request_id'),
                TextColumn::make('rate'),

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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
