<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Storage;
class DonationController extends Controller
{
    protected FonnteService $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    /**
     * Kirim notifikasi WA terima kasih ke donatur.
     */
    private function sendThankYouWA(Donation $donation): void
    {
        if (empty($donation->donor_phone)) return;

        $amount = number_format($donation->amount, 0, ',', '.');
        $programName = $donation->program ? $donation->program->title : 'Umum';
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        $programLink = $donation->program ? "{$frontendUrl}/program-kami/" . $donation->program->slug : $frontendUrl;
        
        $message = "Terima kasih Anda sudah melakukan donasi untuk program \"{$programName}\" sebesar Rp {$amount}\n\nLihat program: {$programLink}";

        $this->fonnte->send($donation->donor_phone, $message);
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id'   => 'nullable|integer',
            'donor_name'   => 'required|string',
            'donor_email'  => 'required|email',
            'donor_phone'  => 'required|string',
            'amount'       => 'required|numeric|min:10000',
            'payment_type' => 'nullable|string',
            'receipt'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        $proofOfPayment = null;
        if ($request->hasFile('receipt')) {
            $proofOfPayment = $request->file('receipt')->store('receipts', 'public');
        }

        $donation = Donation::create([
            'program_id'       => $request->program_id,
            'user_id'          => auth('sanctum')->id(), // Attach user_id if logged in
            'donor_name'       => $request->donor_name,
            'donor_email'      => $request->donor_email,
            'donor_phone'      => $request->donor_phone,
            'amount'           => $request->amount,
            'payment_type'     => $request->payment_type ?? 'manual',
            'proof_of_payment' => $proofOfPayment,
            'status'           => 'pending',
        ]);

        // Kirim WA konfirmasi donasi dibuat
        $this->sendThankYouWA($donation);

        return response()->json([
            'success'  => true,
            'donation' => $donation,
        ]);
    }

    public function uploadReceipt(Request $request, $id)
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $donation = Donation::findOrFail($id);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $donation->update(['proof_of_payment' => $path]);
            return response()->json(['success' => true, 'path' => $path]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    }

    public function myDonations(Request $request)
    {
        $user = $request->user();
        
        $donations = Donation::with('program')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $donations
        ]);
    }
}
