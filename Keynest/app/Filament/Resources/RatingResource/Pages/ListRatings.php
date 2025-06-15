<?php

namespace App\Filament\Resources\RatingResource\Pages;

use App\Filament\Resources\RatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListRatings extends ListRecords
{
    protected static string $resource = RatingResource::class;

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
        if($companyId==1){
            return $query;
        }if($companyId==2){
            return $query->whereIn('studio_id', [$companyId]);
        }else{
            return $query->where('influencer_id', [$companyId]);
        }

    }
}
