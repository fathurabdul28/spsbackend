<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationWebController extends Controller
{

    public function index(Request $request)
    {
        $query = Donation::with('program')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('donor_phone', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(20);

        return view('donation.index', compact('donations'));
    }

    public function show(Donation $donation)
    {
        $donation->load('program');
        return view('donation.show', compact('donation'));
    }

    public function confirm(Donation $donation)
    {
        $donation->update(['status' => 'settlement']);
        return redirect()->back()->with('status', 'Donasi berhasil dikonfirmasi.');
    }

    public function reject(Donation $donation)
    {
        $donation->update(['status' => 'cancel']);
        return redirect()->back()->with('status', 'Donasi berhasil ditolak.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donation.index')->with('status', 'Data donasi berhasil dihapus.');
    }
}
