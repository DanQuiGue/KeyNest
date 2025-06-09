<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FreeWidget;
use App\Filament\Widgets\ProWidget;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-c-presentation-chart-bar';
    protected static ?string $title = 'Estadísticas';
    protected static ?string $slug = 'estadisticas';
    protected static string $view = 'filament.pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return 'Estadísticas';
    }

    protected function getHeaderWidgets(): array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==1){
            return [
            // Tus widgets si eres administrador
            ];
        }if($id==2){
            if($user->plan=='free'){
                return [
                    FreeWidget::class
                ];
            }if($user->plan=='pro'){
                return [
                    ProWidget::class
                ];
            }if($user->plan=='team'){
                return [
                    // Tus widgets si eres empresa team
                ];
            }else{
                return [];
            }

        }else{
            return [
                // Tus widgets si eres influencer
            ];
        }
    }
}
