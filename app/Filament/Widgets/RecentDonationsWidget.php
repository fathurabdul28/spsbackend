<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentDonationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Donasi Terbaru';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Donation::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('donor_name')
                    ->label('Nama Donatur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('donor_email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->paginated([5, 10, 25, 50, 'all'])
            ->defaultPaginationPageOption(5);
    }
}
