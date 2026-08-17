<?php

namespace App\Http\Controllers;

use App\Exports\DonationsExport;
use App\Exports\ProgramsExport;
use App\Exports\NewsExport;
use App\Exports\UsersExport;
use App\Models\Donation;
use App\Models\Program;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // DONATIONS
    public function exportDonationsExcel(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $search = $request->query('search', '');
        $status = $request->query('status', '');
        $filename = 'laporan_donasi_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new DonationsExport($ids, $search, $status), $filename);
    }

    public function exportDonationsPdf(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $search = $request->query('search', '');
        $status = $request->query('status', '');

        $query = Donation::with('program')->latest();

        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                  ->orWhere('donor_email', 'like', '%' . $search . '%')
                  ->orWhere('donor_phone', 'like', '%' . $search . '%');
            });
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $donations = $query->get();

        $pdf = Pdf::loadView('pdf.donations', compact('donations'));
        $filename = 'laporan_donasi_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    // PROGRAMS
    public function exportProgramsExcel(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $filename = 'laporan_program_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new ProgramsExport($ids), $filename);
    }

    public function exportProgramsPdf(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $query = Program::with(['category', 'donations'])->latest();
        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }
        $programs = $query->get();

        $pdf = Pdf::loadView('pdf.programs', compact('programs'));
        $filename = 'laporan_program_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    // NEWS
    public function exportNewsExcel(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $filename = 'laporan_berita_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new NewsExport($ids), $filename);
    }

    public function exportNewsPdf(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $query = News::with('author')->latest();
        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }
        $newsList = $query->get();

        $pdf = Pdf::loadView('pdf.news', compact('newsList'));
        $filename = 'laporan_berita_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    // USERS
    public function exportUsersExcel(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $search = $request->query('search', '');
        $filename = 'laporan_user_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new UsersExport($ids, $search), $filename);
    }

    public function exportUsersPdf(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $search = $request->query('search', '');

        $query = User::latest();
        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $users = $query->get();

        $pdf = Pdf::loadView('pdf.users', compact('users'));
        $filename = 'laporan_user_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
