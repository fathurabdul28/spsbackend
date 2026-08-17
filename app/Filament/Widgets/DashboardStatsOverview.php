<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Donation;
use App\Models\Program;

class DashboardStatsOverview extends Widget
{
    use InteractsWithPageFilters;

    protected static string $view = 'filament.widgets.dashboard-stats-overview';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getViewData(): array
    {
        $filter = $this->filters['period'] ?? 'month';
        
        $donationQuery = Donation::query();
        $programQuery = Program::query();
        
        match ($filter) {
            'today' => [
                $donationQuery->whereDate('created_at', today()),
                $programQuery->whereDate('created_at', today())
            ],
            'week' => [
                $donationQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                $programQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ],
            'month' => [
                $donationQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                $programQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)
            ],
            'year' => [
                $donationQuery->whereYear('created_at', now()->year),
                $programQuery->whereYear('created_at', now()->year)
            ],
            'all' => null,
            default => [
                $donationQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                $programQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)
            ],
        };

        $totalDanaQuery = clone $donationQuery;
        $totalDana = $totalDanaQuery->where('status', 'success')->sum('amount');
        
        $donaturBaruQuery = clone $donationQuery;
        $donaturBaru = $donaturBaruQuery->select('donor_email')->distinct()->count();
        
        $programAktifQuery = clone $programQuery;
        $programAktif = $programAktifQuery->where('is_active', true)->count();
        
        $donasiPendingQuery = clone $donationQuery;
        $donasiPending = $donasiPendingQuery->where('status', 'pending')->count();

        return [
            'totalDana' => 'Rp ' . number_format($totalDana, 0, ',', '.'),
            'donaturBaru' => number_format($donaturBaru, 0, ',', '.'),
            'programAktif' => number_format($programAktif, 0, ',', '.'),
            'donasiPending' => number_format($donasiPending, 0, ',', '.'),
        ];
    }
}
