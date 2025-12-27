<?php

namespace App\Filament\Resources\Challenges\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChallengesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ctfEvent.name')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->searchable(),
                TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Easy' => 'success',
                        'Medium' => 'warning',
                        'Hard' => 'danger',
                        'Insane' => 'danger', // or a custom color
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                 \Filament\Tables\Filters\SelectFilter::make('ctf_event_id')
                    ->relationship('ctfEvent', 'name')
                    ->label('Event'),
                 \Filament\Tables\Filters\SelectFilter::make('category'),
                 \Filament\Tables\Filters\SelectFilter::make('difficulty'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
