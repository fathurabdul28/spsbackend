<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('period')
                    ->label('Pilih Rentang Waktu')
                    ->options([
                        'today' => 'Hari Ini',
                        'week' => 'Minggu Ini',
                        'month' => 'Bulan Ini',
                        'year' => 'Tahun Ini',
                        'all' => 'Semua Waktu',
                    ])
                    ->default('month')
                    ->native(false)
            ])
            ->columns(4);
    }
}
