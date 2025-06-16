<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\Key;
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
    protected function afterSave(): void
    {
        $idkey=$this->record->key_id;
        $state=$this->record->status;
        if($state=="accepted"){
            $key=Key::find($idkey);
            $key->used=true;
            $key->save();
        }

    }
}
