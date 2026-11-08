<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Nama harus sama dengan filter kategori di halaman Program (frontend).
        $categories = [
            'Pendidikan' => 'Bantuan akses dan biaya pendidikan.',
            'Kesehatan' => 'Layanan dan bantuan kesehatan.',
            'Bencana' => 'Tanggap darurat dan pemulihan bencana.',
            'Pemberdayaan' => 'Pelatihan dan modal usaha masyarakat.',
            'Sosial' => 'Santunan dan kegiatan sosial.',
        ];

        foreach ($categories as $name => $description) {
            Category::updateOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name, 'description' => $description]
            );
        }
    }
}
