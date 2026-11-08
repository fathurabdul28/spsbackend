<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@sehatipeduli.org'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );

        $this->call([
            CategorySeeder::class,
            BankAccountSeeder::class,
            ProgramSeeder::class,
            DonationSeeder::class,
            WebSettingSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
