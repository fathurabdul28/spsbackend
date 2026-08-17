<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class DonationChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Rekap Donasi per Program';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $filter = $this->filters['period'] ?? 'month';
        $query = Donation::query()->where('status', 'success');

        match ($filter) {
            'today' => $query->whereDate('created_at', today()),
            'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'year' => $query->whereYear('created_at', now()->year),
            'all' => null, // No filter applied
            default => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
        };

        $donations = $query->selectRaw('program_id, sum(amount) as total_amount')
            ->groupBy('program_id')
            ->with('program')
            ->get();

        $labels = [];
        $data = [];

        foreach ($donations as $donation) {
            $labels[] = $donation->program ? $donation->program->title : 'Tanpa Program';
            $data[] = $donation->total_amount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Terkumpul (Rp)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(124, 58, 237, 0.7)', // Purple solid
                    'borderColor' => '#7c3aed',
                    'borderWidth' => 1,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
