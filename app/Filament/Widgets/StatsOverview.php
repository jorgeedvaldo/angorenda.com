<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total de Imóveis', \App\Models\Property::count())
                ->description('Imóveis publicados')
                ->descriptionIcon('heroicon-s-home')
                ->color('primary'),

            Card::make('Total de Utilizadores', \App\Models\User::count())
                ->description('Contas registadas')
                ->descriptionIcon('heroicon-s-user-group')
                ->color('success'),

            Card::make('Proprietários', \App\Models\User::where('role', 'owner')->count())
                ->description('Clientes ativos')
                ->descriptionIcon('heroicon-s-user')
                ->color('warning'),

            Card::make('Administradores', \App\Models\User::where('role', 'admin')->count())
                ->description('Equipa de gestão')
                ->descriptionIcon('heroicon-s-shield-check')
                ->color('danger'),
        ];
    }
}
