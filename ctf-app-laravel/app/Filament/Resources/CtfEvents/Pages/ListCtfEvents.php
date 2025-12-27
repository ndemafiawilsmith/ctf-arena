<?php

namespace App\Filament\Resources\CtfEvents\Pages;

use App\Filament\Resources\CtfEvents\CtfEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCtfEvents extends ListRecords
{
    protected static string $resource = CtfEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
