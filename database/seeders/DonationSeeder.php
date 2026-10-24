<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::all();
        if ($programs->isEmpty()) {
            return;
        }

        $statuses = ['success', 'pending', 'failed'];
        
        for ($i = 0; $i < 50; $i++) {
            Donation::create([
                'program_id' => $programs->random()->id,
                'donor_name' => 'Donatur ' . $i,
                'donor_email' => 'donatur' . $i . '@example.com',
                'donor_phone' => '0812345678' . rand(10, 99),
                'amount' => rand(50, 500) * 10000,
                'payment_type' => 'manual',
                'status' => $statuses[array_rand($statuses)],
                'snap_token' => Str::random(10),
                'created_at' => now()->subDays(rand(0, 180)), // Spread over last 6 months
            ]);
        }
    }
}
