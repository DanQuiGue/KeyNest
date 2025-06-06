<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Request;
use App\Models\User;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Filament\Support\Colors\Color;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
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
                Select::make('request_id')
                    ->label('Solicitud')
                    ->options(function () {
                        return Request::whereIn('status', ['complete', 'accepted'])
                            ->with(['influencer', 'game'])
                            ->get()
                            ->mapWithKeys(function ($request) {
                                return [
                                    $request->id => ($request->influencer?->name ?? 'Sin influencer') . ' - ' . ($request->game?->title ?? 'Sin juego'),
                                ];
                            });
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        if ($state) {
                            // Obtener el request con su relación
                            $request = Request::with('influencer')->find($state);
                            $set('influencer_id', $request?->influencer_id);
                        } else {
                            $set('influencer_id', null);
                        }
                    }),
                Select::make('influencer_id')
                    ->label('Influencer')
                    ->disabled()
                    ->relationship('influencer','name')
                    ->reactive()
                    ->dehydrated(true),
                Hidden::make('studio_id')
                    ->default(Auth::user()->id),
                Rating::make('rate')
                    ->label('Puntuación')
                    ->theme(RatingTheme::HalfStars)
                    ->stars(5)
                    ->color('warning')
                    ->required(),
                Textarea::make('observation')
                    ->label('Observaciones')
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
                TextColumn::make('influencer.name'),
                TextColumn::make('studio.name'),
                TextColumn::make('request.influencer.name')
                    ->label('Solicitud')
                    ->formatStateUsing(function ($record) {
                        if (!$record->request) return '-';

                        return ($record->request->influencer?->name ?? 'Sin influencer') . ' - ' . ($record->request->game?->title ?? 'Sin juego');
                    }),
                RatingColumn::make('rate'),

            ])
            ->filters([

            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
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
