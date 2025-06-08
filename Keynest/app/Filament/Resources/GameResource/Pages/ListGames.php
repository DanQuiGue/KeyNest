<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getTableQuery();

        // Suponiendo que el usuario logueado tiene el company_id
        $companyId = Auth::user()->id;

        if($companyId==1 || $companyId==3){
            return $query;
        }else{
            return $query->where('company_id', $companyId);
        }

    }

}
