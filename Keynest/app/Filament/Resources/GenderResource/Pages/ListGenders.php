<?php

namespace App\Filament\Resources\GenderResource\Pages;

use App\Filament\Resources\GenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListGenders extends ListRecords
{
    protected static string $resource = GenderResource::class;

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

}
