<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
       if($this->record->type=='user')
       {
            $this->record->roles()->attach(3);
       }else{
            $this->record->roles()->attach(2);
       }
    }
}
