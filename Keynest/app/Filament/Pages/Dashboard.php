<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FreeWidget;
use App\Filament\Widgets\ProWidget;
use App\Filament\Widgets\RootWidget;
use App\Filament\Widgets\TeamWidget;
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

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==3){
            return false;
        }else{
            return true;
        }
    }
    protected function getHeaderWidgets(): array
    {
        $user = Auth::user();
        $id=$user->roles->first()->id;
        if($id==1){
            return [
                RootWidget::class
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
                    TeamWidget::class
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
