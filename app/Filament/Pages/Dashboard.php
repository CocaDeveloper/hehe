<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\UserOverview;
use Filament\Widgets\AccountWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            UserOverview::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }

}