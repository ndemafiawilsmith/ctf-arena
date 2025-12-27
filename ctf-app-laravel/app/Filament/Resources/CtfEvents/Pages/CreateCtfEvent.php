<?php

namespace App\Filament\Resources\CtfEvents\Pages;

use App\Filament\Resources\CtfEvents\CtfEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCtfEvent extends CreateRecord
{
    protected static string $resource = CtfEventResource::class;
}
