<?php

namespace App\Filament\Resources\ScamResource\Pages;

use App\Filament\Resources\ScamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScam extends EditRecord
{
    protected static string $resource = ScamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
