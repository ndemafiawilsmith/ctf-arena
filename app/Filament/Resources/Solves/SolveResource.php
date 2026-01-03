<?php

namespace App\Filament\Resources\Solves;

use App\Filament\Resources\Solves\Pages\ManageSolves;
use App\Models\Solve;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SolveResource extends Resource
{
    protected static ?string $model = Solve::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                \Filament\Forms\Components\Select::make('challenge_id')
                    ->relationship('challenge', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('challenge.title')
                    ->label('Challenge')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Solved At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                 \Filament\Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name'),
                 \Filament\Tables\Filters\SelectFilter::make('challenge_id')
                    ->relationship('challenge', 'title'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSolves::route('/'),
        ];
    }
}
