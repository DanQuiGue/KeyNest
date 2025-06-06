<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
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
}
