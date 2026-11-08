<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Donation;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        // Jangan menumpuk donasi dummy setiap seeder dijalankan ulang.
        if (Donation::where('donor_email', 'like', '%@example.com')->exists()) {
            return;
        }

        $programs = Program::all();
        if ($programs->isEmpty()) {
            return;
        }

        $bankIds = BankAccount::pluck('id');
        $statuses = ['success', 'success', 'success', 'pending', 'failed'];

        for ($i = 1; $i <= 60; $i++) {
            $createdAt = now()->subDays(rand(0, 180));

            Donation::create([
                'program_id' => $programs->random()->id,
                'bank_account_id' => $bankIds->isEmpty() ? null : $bankIds->random(),
                'donor_name' => 'Donatur ' . $i,
                'donor_email' => 'donatur' . $i . '@example.com',
                'donor_phone' => '0812345678' . str_pad((string) rand(0, 99), 2, '0', STR_PAD_LEFT),
                'amount' => rand(5, 100) * 10000,
                'payment_type' => 'manual',
                'status' => $statuses[array_rand($statuses)],
                'snap_token' => Str::random(10),
            ])->forceFill(['created_at' => $createdAt, 'updated_at' => $createdAt])->saveQuietly();
        }
    }
}
