<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Key;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ProWidget extends Widget
{
    protected static string $view = 'filament.widgets.pro-widget';
    protected int | string | array $columnSpan = 'full';


    protected function getViewData(): array
    {
        $user = Auth::user();
        $gameIds = $user->games()->pluck('id');
        $totalKeys = Key::whereIn('game_id', $gameIds)->count();

        $monthlyKeysCount = Key::whereIn('game_id', $user->games()->pluck('id'))
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        $activeGamesCount = Game::where('company_id', $user->id)
            ->whereHas('keys', function ($query) {
                $query->where('used', false);
            })
            ->count();

        $redeemedKeysCount = Key::whereIn('game_id', $gameIds)
                ->where('used', true)
                ->count();

        if($totalKeys==0){
            $conversionRate=0;
        }else{
            $conversionRate = round(($redeemedKeysCount / $totalKeys) * 100) . '%';
        }


        return [
            'thisMonth' => $monthlyKeysCount,
            'maxKeys' => 200,
            'activeGames'=>$activeGamesCount,
            'totalGamesAllowed' => 5,
            'redeemedKeys' => $redeemedKeysCount,
            'conversionRate' => $conversionRate,
        ];
    }
}
