<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\Game;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3 || $id==1){
            return [
                CreateAction::make(),
            ];
        }else{
            return [];
        }
    }
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getTableQuery();

        // Suponiendo que el usuario logueado tiene el company_id
        $role_id= Auth::user()->roles()->first()->id;
        $companyId = Auth::user()->id;
        $games = Game::where('company_id', $companyId)->pluck('id');
        if($role_id==1){
            return $query;
        }if($role_id==2){
            return $query->whereIn('game_id', $games);
        }else{
            return $query->where('influencer_id', $companyId);
        }

    }
}
