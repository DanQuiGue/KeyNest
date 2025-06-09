<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Key;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class FreeWidget extends Widget
{
    protected static string $view = 'filament.widgets.free-widget';

    protected int | string | array $columnSpan = 'full';


    protected function getViewData(): array
    {
        $user = Auth::user();
        $monthlyKeysCount = Key::whereIn('game_id', $user->games()->pluck('id'))
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        $activeGamesCount = Game::where('company_id', $user->id)
            ->whereHas('keys', function ($query) {
                $query->where('used', false);
            })
            ->count();
        return [
            'thisMonth' => $monthlyKeysCount,
            'maxKeys' => 50,
            'activeGames'=>$activeGamesCount,
            'totalGamesAllowed' => 1,
            'redeemedKeys' => 28,
            'conversionRate' => '15%',
        ];
    }
}
