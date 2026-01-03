<?php

namespace App\Filament\Resources\CtfEvents\Pages;

use App\Filament\Resources\CtfEvents\CtfEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCtfEvent extends EditRecord
{
    protected static string $resource = CtfEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
