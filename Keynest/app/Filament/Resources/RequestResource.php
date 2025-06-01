<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Key;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'solicitud';

    public static function getModelLabel(): string
    {
        return 'Solicitud';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Solicitudes';
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3 || $id==1){
            return true;
        }else{
            return false;
        }
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('influencer_id')
                    ->relationship('influencer','name'),
                Select::make('game_id')
                    ->relationship('game','title')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $firstAvailableKeyId = Key::where('used', false)->where('game_id', $state)->value('id');
                        dd($firstAvailableKeyId);
                        $set('key_id', $firstAvailableKeyId);
                    }),
                Hidden::make('key_id'),
                Select::make('status'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('influencer_id'),
                TextColumn::make('game_id'),
                //TextColumn::make('key_id'),
                TextColumn::make('status'),

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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
