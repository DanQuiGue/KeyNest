<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditRequest extends EditRecord
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3 || $id==1){
            return [
            Actions\DeleteAction::make(),
            ];
        }else{
            return [];
        }

    }
}
