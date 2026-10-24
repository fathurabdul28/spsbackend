<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::with('category')->withCount(['donations as donors_count' => function ($query) {
            $query->where('status', 'success');
        }])->withSum(['donations as collected_amount' => function ($query) {
            $query->where('status', 'success');
        }], 'amount')->where('is_active', true);

        if ($request->has('category') && $request->category !== 'Semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $programs = $query->latest()->get();

        // Format data to match frontend expectations
        $formattedPrograms = $programs->map(function ($program) {
            $progress = $program->target_amount > 0 ? min(100, ($program->collected_amount / $program->target_amount) * 100) : 0;
            return [
                'id' => $program->id,
                'slug' => $program->slug,
                'title' => $program->title,
                'description' => $program->description,
                'image' => $program->image,
                'progress' => round($progress),
                'collected' => 'Rp ' . number_format($program->collected_amount ?? 0, 0, ',', '.'),
                'target' => 'Rp ' . number_format($program->target_amount, 0, ',', '.'),
                'target_raw' => $program->target_amount,
                'collected_raw' => $program->collected_amount ?? 0,
                'target_amount' => $program->target_amount,
                'collected_amount' => $program->collected_amount ?? 0,
                'donors' => $program->donors_count,
                'category' => $program->category ? $program->category->name : 'Umum',
                'distribution_date' => $program->distribution_date,
                'distribution_photos' => $program->distribution_photos,
                'location' => $program->location,
                'location_url' => $program->location_url,
            ];
        });

        return response()->json($formattedPrograms);
    }

    public function show($slug)
    {
        $program = Program::with(['category', 'donations' => function ($query) {
            $query->where('status', 'success')->latest();
        }])->withCount(['donations as donors_count' => function ($query) {
            $query->where('status', 'success');
        }])->withSum(['donations as collected_amount' => function ($query) {
            $query->where('status', 'success');
        }], 'amount')->where('slug', $slug)->firstOrFail();

        $progress = $program->target_amount > 0 ? min(100, ($program->collected_amount / $program->target_amount) * 100) : 0;

        $formattedProgram = [
            'id' => $program->id,
            'slug' => $program->slug,
            'title' => $program->title,
            'description' => $program->description,
            'image' => $program->image,
            'progress' => round($progress),
            'collected' => 'Rp ' . number_format($program->collected_amount ?? 0, 0, ',', '.'),
            'target' => 'Rp ' . number_format($program->target_amount, 0, ',', '.'),
            'target_raw' => $program->target_amount,
            'collected_raw' => $program->collected_amount ?? 0,
            'target_amount' => $program->target_amount,
            'collected_amount' => $program->collected_amount ?? 0,
            'donors' => $program->donors_count,
            'recent_donations' => $program->donations->map(function ($d) {
                return [
                    'name' => empty($d->donor_name) ? 'Hamba Allah' : $d->donor_name,
                    'amount' => 'Rp ' . number_format($d->amount, 0, ',', '.'),
                    'date' => $d->created_at ? $d->created_at->diffForHumans() : 'Hari ini',
                ];
            })->values(),
            'category' => $program->category ? $program->category->name : 'Umum',
            'distribution_date' => $program->distribution_date,
            'distribution_photos' => $program->distribution_photos,
            'location' => $program->location,
            'location_url' => $program->location_url,
        ];

        return response()->json($formattedProgram);
    }
}
