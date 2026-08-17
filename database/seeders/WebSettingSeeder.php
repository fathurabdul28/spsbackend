<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebSettingSeeder extends Seeder
{
    public function run()
    {
        DB::table('web_settings')->insert([
            'about_us_text' => 'Sehati Peduli Sesama adalah yayasan sosial dan kemanusiaan yang hadir sebagai wadah untuk menyalurkan kepedulian kepada masyarakat yang membutuhkan. Berlandaskan nilai kemanusiaan, keikhlasan, dan gotong royong, kami berkomitmen menghadirkan berbagai program sosial yang memberikan manfaat nyata serta mendorong terciptanya kehidupan yang lebih baik. Melalui program di bidang sosial, pendidikan, kesehatan, kebencanaan, dan pemberdayaan masyarakat, kami berupaya menjadi jembatan antara para dermawan dengan mereka yang membutuhkan.',
            'vision' => 'Menjadi lembaga sosial kemanusiaan terpercaya yang berkontribusi aktif dalam mengentaskan kemiskinan dan meningkatkan kesejahteraan masyarakat Indonesia secara berkelanjutan.',
            'mission' => json_encode([
                'Menyelenggarakan program bantuan pendidikan bagi anak-anak kurang mampu agar mendapatkan akses pendidikan yang layak.',
                'Memberikan layanan kesehatan gratis dan bantuan medis untuk masyarakat di daerah terpencil dan prasejahtera.',
                'Memberdayakan ekonomi masyarakat kecil (UMKM) melalui pemberian modal usaha tanpa bunga dan pelatihan kemandirian.',
                'Menyalurkan bantuan tanggap darurat secara cepat dan tepat sasaran bagi korban bencana alam.'
            ]),
            'about_image' => '/tentangkami.png',
            'contact_email' => 'halo@sehatipeduli.org',
            'contact_phone' => '081234567890',
            'address' => 'Jl. Kebaikan No. 99, Jakarta Selatan, Indonesia',
            'social_media' => json_encode([
                'instagram' => 'https://instagram.com/sehatipedulisesama',
                'facebook' => 'https://facebook.com/sehatipedulisesama',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
