<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    private const MAPS_URL = 'https://maps.app.goo.gl/YiQUbcE6jamPasiT9';

    public function run(): void
    {
        $programs = [
            [
                'category' => 'Sosial',
                'title' => 'Camping Ceria',
                'description' => 'Camping Ceria merupakan program kegiatan tahunan yang rutin diselenggarakan untuk menghadirkan keceriaan dan pengalaman berharga bagi anak-anak yatim serta dhuafa. Melalui perkemahan di alam terbuka, aktivitas edukatif, permainan kekompakan, dan malam kebersamaan, program ini bertujuan menumbuhkan rasa percaya diri, kemandirian, serta kehangatan kasih sayang bagi mereka.',
                'location' => 'Lembang / KBB',
                'image' => '/santri-adventure-camp.jpg',
                'target_amount' => 35000000,
                'distribution_date' => '2026-11-21',
            ],
            [
                'category' => 'Pendidikan',
                'title' => 'Beasiswa Pelita Hati',
                'description' => 'Dukungan biaya sekolah dan perlengkapan belajar selama satu tahun bagi siswa berprestasi dari keluarga prasejahtera, dari tingkat SD hingga SMA.',
                'location' => 'Bandung',
                'image' => '/pendidikan.jpg',
                'target_amount' => 50000000,
                'distribution_date' => '2026-12-10',
            ],
            [
                'category' => 'Bencana',
                'title' => 'Tanggap Bencana Banjir',
                'description' => 'Penyaluran paket sembako, selimut, dan kebutuhan mendesak bagi warga terdampak banjir agar dapat segera memulihkan kehidupan mereka.',
                'location' => 'Demak, Jawa Tengah',
                'image' => '/fotobencanalam.jpg',
                'target_amount' => 75000000,
                'distribution_date' => '2026-10-15',
            ],
            [
                'category' => 'Pemberdayaan',
                'title' => 'Pemberdayaan UMKM Sehati',
                'description' => 'Pemberian modal usaha tanpa bunga dan pelatihan kemandirian bagi pelaku usaha kecil agar penghasilan keluarga lebih stabil.',
                'location' => 'Kota Bandung',
                'image' => '/pemberdayaan_umkm.webp',
                'target_amount' => 40000000,
                'distribution_date' => '2027-01-20',
            ],
            [
                'category' => 'Kesehatan',
                'title' => 'Layanan Kesehatan Gratis',
                'description' => 'Pemeriksaan kesehatan dan pembagian obat gratis bagi warga prasejahtera di daerah yang sulit menjangkau fasilitas kesehatan.',
                'location' => 'Garut, Jawa Barat',
                'image' => '/dasboard1.png',
                'target_amount' => 30000000,
                'distribution_date' => '2026-09-05',
            ],
        ];

        foreach ($programs as $data) {
            $category = Category::where('slug', str($data['category'])->slug())->first();

            Program::updateOrCreate(
                ['slug' => str($data['title'])->slug()],
                [
                    'category_id' => $category?->id,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'location' => $data['location'],
                    'location_url' => self::MAPS_URL,
                    'distribution_date' => $data['distribution_date'],
                    'image' => $data['image'],
                    'target_amount' => $data['target_amount'],
                    'is_active' => true,
                ]
            );
        }
    }
}
