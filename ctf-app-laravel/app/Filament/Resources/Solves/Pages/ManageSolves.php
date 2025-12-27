<?php

namespace App\Filament\Resources\Solves\Pages;

use App\Filament\Resources\Solves\SolveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSolves extends ManageRecords
{
    protected static string $resource = SolveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
