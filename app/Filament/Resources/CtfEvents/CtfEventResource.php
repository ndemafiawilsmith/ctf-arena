<?php

namespace App\Filament\Resources\CtfEvents;

use App\Filament\Resources\CtfEvents\Pages\CreateCtfEvent;
use App\Filament\Resources\CtfEvents\Pages\EditCtfEvent;
use App\Filament\Resources\CtfEvents\Pages\ListCtfEvents;
use App\Filament\Resources\CtfEvents\Schemas\CtfEventForm;
use App\Filament\Resources\CtfEvents\Tables\CtfEventsTable;
use App\Models\CtfEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CtfEventResource extends Resource
{
    protected static ?string $model = CtfEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Events';

    public static function form(Schema $schema): Schema
    {
        return CtfEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CtfEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCtfEvents::route('/'),
            'create' => CreateCtfEvent::route('/create'),
            'edit' => EditCtfEvent::route('/{record}/edit'),
        ];
    }
}
