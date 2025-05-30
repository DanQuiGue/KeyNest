<?php

namespace App\Filament\Imports;

use App\Models\Key;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class KeyImporter extends Importer
{
    protected static ?string $model = Key::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('key')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Key
    {

        return new Key([
            'game_id'=>$this->getOptions()['gameId'],
            'key'=>$this->data['key'],
            'used'=>false
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your key import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
