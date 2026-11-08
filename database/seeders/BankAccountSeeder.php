<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Nomor rekening di bawah hanya dummy. Ganti lewat panel admin sebelum produksi.
        $accounts = [
            ['bank_name' => 'Bank BCA', 'account_number' => '0000000001', 'account_name' => 'Yayasan Sehati Peduli Sesama'],
            ['bank_name' => 'Bank BSI', 'account_number' => '0000000002', 'account_name' => 'Yayasan Sehati Peduli Sesama'],
        ];

        foreach ($accounts as $account) {
            BankAccount::updateOrCreate(
                ['bank_name' => $account['bank_name'], 'account_number' => $account['account_number']],
                $account + ['is_active' => true]
            );
        }
    }
}
