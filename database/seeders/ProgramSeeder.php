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
        $category = Category::firstOrCreate(['slug' => 'sosial'], ['name' => 'Sosial']);

        $prog = Program::create([
            'category_id' => $category->id,
            'title' => 'Camping Ceria',
            'slug' => 'camping-ceria',
            'description' => 'Camping Ceria merupakan program kegiatan tahunan yang rutin diselenggarakan untuk menghadirkan keceriaan dan pengalaman berharga bagi anak-anak yatim serta dhuafa. Melalui perkemahan di alam terbuka, aktivitas edukatif, permainan kekompakan, dan malam kebersamaan, program ini bertujuan menumbuhkan rasa percaya diri, kemandirian, serta kehangatan kasih sayang bagi mereka.',
            'location' => 'Lembang / KBB',
            'location_url' => 'https://maps.app.goo.gl/YiQUbcE6jamPasiT9',
            'distribution_date' => '2026-11-21',
            'image' => '/santri-adventure-camp.jpg',
            'target_amount' => 35000000,
            'is_active' => true,
        ]);
    }
}
