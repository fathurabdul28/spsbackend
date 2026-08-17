<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class ProgramPerformanceWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Jumlah Donatur per Program';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $filter = $this->filters['period'] ?? 'month';
        $query = Donation::query()->where('status', 'success');

        match ($filter) {
            'today' => $query->whereDate('created_at', today()),
            'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'year' => $query->whereYear('created_at', now()->year),
            'all' => null,
            default => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
        };

        $donations = $query->selectRaw('program_id, count(distinct donor_email) as total_donors')
            ->groupBy('program_id')
            ->with('program')
            ->get();

        $labels = [];
        $data = [];
        $colors = ['#7c3aed', '#3b82f6', '#14b8a6', '#f59e0b', '#ef4444', '#8b5cf6'];

        foreach ($donations as $index => $donation) {
            $labels[] = $donation->program ? $donation->program->title : 'Tanpa Program';
            $data[] = $donation->total_donors;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Donatur',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
