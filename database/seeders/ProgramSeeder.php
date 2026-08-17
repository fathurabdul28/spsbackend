<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Program;
use App\Models\Donation;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $catPendidikan = Category::create(['name' => 'Pendidikan', 'slug' => 'pendidikan']);
        $catKesehatan = Category::create(['name' => 'Kesehatan', 'slug' => 'kesehatan']);
        $catBencana = Category::create(['name' => 'Bencana', 'slug' => 'bencana']);
        $catPemberdayaan = Category::create(['name' => 'Pemberdayaan', 'slug' => 'pemberdayaan']);

        $prog1 = Program::create([
            'category_id' => $catPendidikan->id,
            'title' => 'Beasiswa Pelita Hati untuk Anak Yatim',
            'slug' => 'program-beasiswa-pelita-hati',
            'description' => 'Program ini didedikasikan untuk memberikan beasiswa penuh kepada anak-anak yatim dan dhuafa yang berprestasi namun terkendala biaya. Bantuan mencakup biaya SPP, seragam, dan alat tulis selama satu tahun ajaran.',
            'image' => '/pendidikan.jpg',
            'target_amount' => 50000000,
            'is_active' => true,
        ]);

        $prog2 = Program::create([
            'category_id' => $catKesehatan->id,
            'title' => 'Layanan Kesehatan Gratis di Pelosok Desa',
            'slug' => 'layanan-kesehatan-pelosok',
            'description' => 'Banyak saudara kita di daerah terpencil yang kesulitan mengakses layanan medis yang layak. Melalui program ini, kami menghadirkan dokter sukarelawan dan obat-obatan gratis langsung ke desa-desa yang membutuhkan.',
            'image' => '/campingceria.png', // Menggunakan gambar yang ada sementara
            'target_amount' => 35000000,
            'is_active' => true,
        ]);

        $prog3 = Program::create([
            'category_id' => $catBencana->id,
            'title' => 'Bantuan Sembako Korban Banjir Bandang',
            'slug' => 'unit-respon-cepat-bencana',
            'description' => 'Bencana banjir telah menghanyutkan banyak rumah warga. Unit Respon Cepat kami sedang mengumpulkan donasi untuk mendistribusikan paket sembako, pakaian layak pakai, dan air bersih ke posko-posko pengungsian.',
            'image' => '/fotobencanalam.jpg',
            'target_amount' => 100000000,
            'is_active' => true,
        ]);

        $prog4 = Program::create([
            'category_id' => $catPemberdayaan->id,
            'title' => 'Modal Usaha untuk Ibu Tangguh (UMKM)',
            'slug' => 'pemberdayaan-umkm',
            'description' => 'Bantu para ibu tunggal yang menjadi tulang punggung keluarga dengan memberikan modal usaha tanpa bunga. Dana ini akan digunakan untuk membeli gerobak jualan dan bahan baku awal agar mereka bisa mandiri secara finansial.',
            'image' => '/pemberdayaan_umkm.webp',
            'target_amount' => 25000000,
            'is_active' => true,
        ]);

        // Add some dummy donations so the progress isn't 0
        Donation::create([
            'program_id' => $prog1->id,
            'donor_name' => 'John Doe',
            'donor_email' => 'john@example.com',
            'donor_phone' => '08123456789',
            'amount' => 8500000,
            'payment_type' => 'manual',
            'status' => 'success'
        ]);

        Donation::create([
            'program_id' => $prog2->id,
            'donor_name' => 'Jane Smith',
            'donor_email' => 'jane@example.com',
            'donor_phone' => '08123456789',
            'amount' => 12000000,
            'payment_type' => 'midtrans',
            'status' => 'success'
        ]);

        Donation::create([
            'program_id' => $prog3->id,
            'donor_name' => 'Budi',
            'donor_email' => 'budi@example.com',
            'donor_phone' => '08123456789',
            'amount' => 30000000,
            'payment_type' => 'manual',
            'status' => 'success'
        ]);
        
        Donation::create([
            'program_id' => $prog4->id,
            'donor_name' => 'Siti',
            'donor_email' => 'siti@example.com',
            'donor_phone' => '08123456789',
            'amount' => 13500000,
            'payment_type' => 'midtrans',
            'status' => 'success'
        ]);
    }
}
