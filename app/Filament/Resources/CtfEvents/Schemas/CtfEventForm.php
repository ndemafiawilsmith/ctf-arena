<?php

namespace App\Filament\Resources\CtfEvents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CtfEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\DateTimePicker::make('start_time'),
                \Filament\Forms\Components\DateTimePicker::make('end_time')
                     ->after('start_time'),
                \Filament\Forms\Components\Toggle::make('is_paid')
                    ->label('Paid Event')
                    ->live(),
                \Filament\Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->hidden(fn ($get) => ! $get('is_paid'))
                    ->required(fn ($get) => $get('is_paid')),
                \Filament\Forms\Components\FileUpload::make('cover_image_url')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('ctf-events'),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
                Section::make('Rewards')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_rewarded')
                            ->label('Reward-Enabled Event')
                            ->helperText('Enable to assign prizes for 1st, 2nd, and 3rd place.')
                            ->live()
                            ->default(false),
                        Grid::make(3)
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('first_prize')
                                    ->label('1st Place Prize')
                                    ->required(fn ($get) => $get('is_rewarded'))
                                    ->visible(fn ($get) => $get('is_rewarded')),
                                \Filament\Forms\Components\TextInput::make('second_prize')
                                    ->label('2nd Place Prize')
                                    ->required(fn ($get) => $get('is_rewarded'))
                                    ->visible(fn ($get) => $get('is_rewarded')),
                                \Filament\Forms\Components\TextInput::make('third_prize')
                                    ->label('3rd Place Prize')
                                    ->required(fn ($get) => $get('is_rewarded'))
                                    ->visible(fn ($get) => $get('is_rewarded')),
                            ]),
                        \Filament\Forms\Components\TextInput::make('sponsor')
                            ->label('Event Sponsor')
                            ->placeholder('e.g., Google, Offensive Security')
                            ->visible(fn ($get) => $get('is_rewarded')),
                    ])
                    ->collapsible(),
            ]);
    }
}
