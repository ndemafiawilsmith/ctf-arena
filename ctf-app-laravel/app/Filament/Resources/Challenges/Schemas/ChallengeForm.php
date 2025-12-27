<?php

namespace App\Filament\Resources\Challenges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ChallengeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('ctf_event_id')
                    ->relationship('ctfEvent', 'name')
                    ->label('Event')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\TextInput::make('category')
                    ->required()
                    ->datalist(['Web', 'Pwn', 'Crypto', 'Forensics', 'Reverse', 'Misc']),
                \Filament\Forms\Components\Select::make('difficulty')
                    ->options([
                        'Easy' => 'Easy',
                        'Medium' => 'Medium',
                        'Hard' => 'Hard',
                        'Insane' => 'Insane',
                    ])
                    ->required(),
                \Filament\Forms\Components\TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                \Filament\Forms\Components\TextInput::make('external_link')
                    ->url()
                    ->prefix('https://'),
                \Filament\Forms\Components\TextInput::make('flag_hash')
                    ->label('Flag')
                    ->helperText('Enter the cleartext flag. It will be hashed securely.')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn ($state) => hash('sha256', $state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                \Filament\Forms\Components\Repeater::make('hints') // Cast to array in Model
                    ->simple(
                        \Filament\Forms\Components\TextInput::make('content')->required()
                    )
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
