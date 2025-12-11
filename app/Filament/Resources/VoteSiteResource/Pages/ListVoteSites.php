<?php

namespace App\Filament\Resources\VoteSiteResource\Pages;

use App\Filament\Resources\VoteSiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVoteSites extends ListRecords
{
    protected static string $resource = VoteSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
