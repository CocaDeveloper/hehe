<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    protected ?string $heading = 'Jogadores';

    protected ?string $description = 'Analise dos jogadores do servidor.';

    protected function getStats(): array
    {
        $players = User::count();
        $partners = User::where('has_partner', 1)->count();
        $playersBanned = User::where('state', '<>', 0)->where('state', '<>', 5)->count();

        return [
            Stat::make('Jogadores Registrados', $this->formatNumber($players)),
            Stat::make('Jogadores Banidos', $this->formatNumber($playersBanned)),
            Stat::make('Parceiros', $this->formatNumber($partners))
        ];
    }

    protected function formatNumber($number): string
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 2) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 2) . 'k';
        }

        return (string)$number;
    }
}
