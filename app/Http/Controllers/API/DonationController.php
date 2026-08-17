<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    protected FonnteService $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

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
            'payment_type' => 'required|in:midtrans,manual'
        ]);

        $donation = Donation::create([
            'program_id'   => $request->program_id,
            'user_id'      => auth('sanctum')->id(), // Attach user_id if logged in
            'donor_name'   => $request->donor_name,
            'donor_email'  => $request->donor_email,
            'donor_phone'  => $request->donor_phone,
            'amount'       => $request->amount,
            'payment_type' => $request->payment_type,
            'status'       => 'pending',
        ]);

        // Jika Midtrans, generate Snap Token (WA dikirim setelah webhook berhasil)
        if ($request->payment_type === 'midtrans') {
            $params = [
                'transaction_details' => [
                    'order_id'     => $donation->id,
                    'gross_amount' => $donation->amount,
                ],
                'customer_details' => [
                    'first_name' => $donation->donor_name,
                    'email'      => $donation->donor_email,
                    'phone'      => $donation->donor_phone,
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $donation->update(['snap_token' => $snapToken]);
                
                return response()->json([
                    'success'    => true,
                    'donation'   => $donation,
                    'snap_token' => $snapToken
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // Jika manual — kirim WA terima kasih langsung setelah donasi dibuat
        $this->sendThankYouWA($donation);

        return response()->json([
            'success'  => true,
            'donation' => $donation,
        ]);
    }

    public function webhook(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $donation = Donation::find($request->order_id);
        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            $donation->update(['status' => 'success']);

            // Kirim WA terima kasih setelah pembayaran Midtrans berhasil dikonfirmasi
            $this->sendThankYouWA($donation);

        } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
            $donation->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Webhook received']);
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
