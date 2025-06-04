<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Filament\Support\Colors\Color;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Mokhosh\FilamentRating\RatingTheme;

class RatingResource extends Resource
{
    protected static ?string $model = \App\Models\Rating::class;

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

    public static function getForm():array
    {
        return [
                TextInput::make('request_id')
                    ->label('Solicitud'),
                TextInput::make('influencer_id')
                    ->label('Influencer'),
                TextInput::make('studio_id')
                    ->label('Compañia'),
                Rating::make('rate')
                    ->label('Puntuación')
                    ->theme(RatingTheme::HalfStars)
                    ->stars(5)
                    ->color('primary'),
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
                TextColumn::make('influencer_id'),
                TextColumn::make('studio_id'),
                TextColumn::make('request_id'),
                RatingColumn::make('rate'),

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
