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
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
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
            $verified=$user->verified;
            if($id==3 && !$verified){
                return false;
            }else{
                return true;
            }
        }
    public static function adminForm():array
    {
        return [
                Select::make('influencer_id')
                    ->relationship('influencer','name'),
                Select::make('game_id')
                    ->relationship('game','title')
                    ->reactive()
                    ->label('Juego')
                    ->afterStateUpdated(function (callable $set, $state) {
                        $firstAvailableKeyId = Key::where('used', false)->where('game_id', $state)->value('id');
                        dd($firstAvailableKeyId);
                        $set('key_id', $firstAvailableKeyId);
                    }),
                Hidden::make('key_id'),
                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pending'=>'Pendiente',
                        'accepted'=>'Aceptada',
                        'rejected'=>'Denegada',
                        'complete'=>'Completa'
                    ]),
                ];
    }

    public static function userForm():array
    {
        return [
                Hidden::make('influencer_id')
                    ->default(Auth::user()->id),
                Select::make('game_id')
                    ->relationship('game','title')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $firstAvailableKeyId = Key::where('used', false)->where('game_id', $state)->value('id');
                        $set('key_id', $firstAvailableKeyId);
                    }),
                Hidden::make('key_id'),
                ];
    }

    public static function companyForm():array
    {
        return [
                Select::make('influencer_id')
                    ->relationship('influencer','nickname')
                    ->disabled()
                    ->dehydrated(true),
                Select::make('game_id')
                    ->relationship('game','title')
                    ->reactive()
                    ->label('Juego')
                    ->afterStateUpdated(function (callable $set, $state) {
                        $firstAvailableKeyId = Key::where('used', false)->where('game_id', $state)->value('id');
                        dd($firstAvailableKeyId);
                        $set('key_id', $firstAvailableKeyId);
                    })
                    ->disabled()
                    ->dehydrated(true),
                Hidden::make('key_id'),
                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pending'=>'Pendiente',
                        'accepted'=>'Aceptada',
                        'rejected'=>'Denegada',
                        'complete'=>'Completa'
                    ]),
                ];
    }
    public static function getActions():array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==1){
            return [
                EditAction::make(),
                DeleteAction::make()
            ];
        }if($id==2){
            return[
                EditAction::make(),
            ];
        }else{
            return[];
        }
    }
    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==1){
            return $form
            ->schema(self::adminForm());
        }
        if($id==2){
            return $form
            ->schema(self::companyForm());
        }else{
            return $form
            ->schema(self::userForm());
        }

    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        return $table
            ->columns([
                TextColumn::make('influencer.nickname'),
                TextColumn::make('game.title'),
                //TextColumn::make('key_id'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'gray',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'complete' => 'info',
                        default    => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'  => 'Pendiente',
                        'accepted' => 'Aceptada',
                        'rejected' => 'Denegada',
                        'complete' => 'Completa',
                        default    => ucfirst($state),
                    })
            ])
            ->filters([

            ])
            ->actions(self::getActions())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(fn ($record) => $id === 1 ? route('filament.admin.resources.solicitud.edit', $record) : null);
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
