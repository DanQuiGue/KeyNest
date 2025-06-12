<?php

namespace App\Filament\Imports;

use App\Models\Key;
use Carbon\Carbon;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'game_id' => $this->getOptions()['gameId'],
            'key' => $this->data['key'],
            'used' => false
        ]);
    }

    // Método que se ejecuta antes de iniciar la importación
    public static function beforeImport(Import $import): void
    {
        $user = Auth::user();

        // Obtener claves actuales del mes
        $currentMonthKeys = Key::whereHas('game', function ($query) use ($user) {
                $query->where('company_id', $user->id);
            })
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        // Total de filas a importar
        $incomingKeys = $import->total_rows;
        $maxKeys = 50;

        if (($currentMonthKeys + $incomingKeys) > $maxKeys) {
            $remaining = $maxKeys - $currentMonthKeys;

            // Lanzar excepción de validación para detener la importación
            throw ValidationException::withMessages([
                'import' => [
                    "Límite de claves alcanzado. Máximo {$maxKeys} claves por mes. " .
                    "Actualmente tienes {$currentMonthKeys} claves. " .
                    "Puedes agregar máximo {$remaining} claves más."
                ]
            ]);
        }
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
