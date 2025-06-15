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
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3){
            return[];
        }else{
            return [
                Actions\CreateAction::make(),
            ];
        }
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getTableQuery();

        // Suponiendo que el usuario logueado tiene el company_id
        $id_role = Auth::user()->roles()->first()->id;
        $id_user=Auth::user()->id;
        if($id_role==2){
            return $query->where('company_id', $id_user);
        }else{
            return $query;
        }

    }

}
