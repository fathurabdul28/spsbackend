<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Donation;
use App\Models\News;
use App\Models\User;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $period = $request->get('period', 'all');

        // Main Stat Cards (Filtered according to period)
        $statQuery = Donation::query()->whereIn('status', ['settlement', 'success', 'pending']);
        $this->applyPeriodFilter($statQuery, $period);

        $totalDonations     = (clone $statQuery)->sum('amount');
        $totalDonationCount = (clone $statQuery)->count();
        $totalDonors        = (clone $statQuery)->distinct('donor_email')->count('donor_email');
        
        $totalPrograms      = Program::count();
        $activePrograms     = Program::where('is_active', true)->count();
        $totalNews          = News::count();
        $totalUsers         = User::count();

        // 1. Diagram Batang: Rekap Donasi (Total Terkumpul Rp) per Program
        $barQuery = Donation::query()->whereIn('status', ['settlement', 'success', 'pending']);
        $this->applyPeriodFilter($barQuery, $period);
        $barDonations = $barQuery->selectRaw('program_id, sum(amount) as total_amount')
            ->groupBy('program_id')
            ->with('program')
            ->get();

        $barLabels = [];
        $barData   = [];
        foreach ($barDonations as $don) {
            $barLabels[] = $don->program ? $don->program->title : 'Tanpa Program';
            $barData[]   = (float) $don->total_amount;
        }

        // 2. Diagram Lingkaran (Pie/Donut): Jumlah Donatur per Program
        $pieQuery = Donation::query()->whereIn('status', ['settlement', 'success', 'pending']);
        $this->applyPeriodFilter($pieQuery, $period);
        $pieDonations = $pieQuery->selectRaw('program_id, count(distinct donor_email) as total_donors')
            ->groupBy('program_id')
            ->with('program')
            ->get();

        $pieLabels = [];
        $pieData   = [];
        $pieColors = ['#7c3aed', '#3b82f6', '#14b8a6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'];
        foreach ($pieDonations as $don) {
            $pieLabels[] = $don->program ? $don->program->title : 'Tanpa Program';
            $pieData[]   = (int) $don->total_donors;
        }
        $pieColors = array_slice($pieColors, 0, max(count($pieData), 1));

        $recentDonations = Donation::with('program')
            ->latest()
            ->take(5)
            ->get();

        $recentPrograms = Program::latest()->take(5)->get();

        return view('dashboard.show', compact(
            'period',
            'totalPrograms',
            'activePrograms',
            'totalDonations',
            'totalDonationCount',
            'totalDonors',
            'totalNews',
            'totalUsers',
            'recentDonations',
            'recentPrograms',
            'barLabels',
            'barData',
            'pieLabels',
            'pieData',
            'pieColors'
        ));
    }

    private function applyPeriodFilter($query, string $period)
    {
        match ($period) {
            'today' => $query->whereDate('created_at', today()),
            'week'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'year'  => $query->whereYear('created_at', now()->year),
            'all'   => null,
            default => null,
        };
    }
}
