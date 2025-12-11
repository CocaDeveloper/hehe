<?php

namespace App\Filament\Resources\VoteSiteResource\Pages;

use App\Filament\Resources\VoteSiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVoteSite extends EditRecord
{
    protected static string $resource = VoteSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
