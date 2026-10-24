<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('news')->insert([
            [
                'title' => 'Penyaluran Bantuan Sembako untuk Korban Banjir Demak',
                'slug' => 'penyaluran-bantuan-sembako-untuk-korban-banjir-demak',
                'content' => 'Tim relawan Sehati Peduli Sesama telah berhasil menyalurkan lebih dari 500 paket sembako kepada warga yang terdampak banjir bandang di wilayah Demak. Bantuan ini merupakan hasil donasi dari para dermawan yang terkumpul melalui platform kami. Masyarakat sangat bersyukur atas bantuan cepat tanggap yang diberikan di saat masa pemulihan pasca bencana.',
                'image' => '/fotobencanalam.jpg',
                'author_id' => 1,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'Beasiswa Pelita Hati Angkatan Ke-5 Resmi Dibuka',
                'slug' => 'beasiswa-pelita-hati-angkatan-ke-5-resmi-dibuka',
                'content' => 'Kabar gembira bagi para pelajar berprestasi dari keluarga prasejahtera! Program Beasiswa Pelita Hati angkatan ke-5 kini resmi dibuka. Program ini akan menjaring 100 siswa-siswi dari tingkat SD hingga SMA untuk diberikan pendampingan dan dukungan biaya sekolah selama satu tahun penuh. Pendaftaran dapat dilakukan melalui mitra relawan kami di daerah masing-masing.',
                'image' => '/pendidikan.jpg',
                'author_id' => 1,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Acara Sehat Camping Ceria',
                'slug' => 'acara-sehat-camping-ceria',
                'content' => 'Dalam rangka menghadirkan kebahagiaan dan kesehatan bagi anak-anak yatim dan dhuafa, Yayasan Sehati Peduli Sesama menyelenggarakan kegiatan Acara Sehat Camping Ceria di alam terbuka. Kegiatan ini diisi dengan berbagai aktivitas edukatif, senam sehat, tadabbur alam, games kebersamaan, dan pembagian paket santunan. Mari terus dukung program kepedulian sesama untuk menghadirkan lebih banyak senyuman bagi anak-anak Indonesia.',
                'image' => '/campingceria.png',
                'author_id' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ]
        ]);
    }
}
