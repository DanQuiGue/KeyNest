<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use App\Filament\Imports\KeyImporter;
use App\Filament\Resources\KeyResource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeysRelationManager extends RelationManager
{
    protected static string $relationship = 'keys';

    public function form(Form $form): Form
    {
        return $form
            ->schema(KeyResource::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                Tables\Columns\TextColumn::make('key'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                ImportAction::make()
                    ->importer(KeyImporter::class)
                    ->options([
                        'gameId' => $this->getOwnerRecord()->id,
                    ])
                    ->label('Importar')
                    ->icon('heroicon-o-document-arrow-down')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
