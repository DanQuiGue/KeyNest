<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PaymentWidget;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Support\Enums\MaxWidth;
use TomatoPHP\FilamentPayments\Facades\FilamentPayments;
use TomatoPHP\FilamentPayments\Filament\Actions\PaymentAction;
use TomatoPHP\FilamentPayments\Services\Contracts\PaymentBillingInfo;
use TomatoPHP\FilamentPayments\Services\Contracts\PaymentCustomer;
use TomatoPHP\FilamentPayments\Services\Contracts\PaymentRequest;
use TomatoPHP\FilamentPayments\Services\Contracts\PaymentShippingInfo;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationLabel = 'Principal';
    protected static ?string $slug = 'principal';
    protected static string $view = 'filament-panels::pages.dashboard';


    public function getWidgets(): array
    {
        return [

        ];
    }

    // Acción para crear un pago rápido desde el dashboard
    protected function getHeaderActions(): array
    {
        return [
            PaymentAction::make('payment')
            ->request(function ($record){
                    return PaymentRequest::make()
                        ->currency('USD')
                        ->amount($record->total)
                        ->details($record->ordersItems()->pluck('product_id')->implode(', '))
                        ->success_url(url('/success'))
                        ->cancel_url(url('/cancel'));
            })
        ];
    }


}
