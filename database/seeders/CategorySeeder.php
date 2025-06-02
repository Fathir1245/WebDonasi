<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pendidikan',
                'description' => 'Kampanye untuk mendukung pendidikan, beasiswa, dan fasilitas belajar'
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Kampanye untuk bantuan medis, pengobatan, dan fasilitas kesehatan'
            ],
            [
                'name' => 'Bencana Alam',
                'description' => 'Kampanye untuk korban bencana alam dan pemulihan pasca bencana'
            ],
            [
                'name' => 'Sosial',
                'description' => 'Kampanye untuk kegiatan sosial dan bantuan masyarakat'
            ],
            [
                'name' => 'Lingkungan',
                'description' => 'Kampanye untuk pelestarian lingkungan dan keberlanjutan'
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Kampanye untuk pengembangan teknologi dan inovasi'
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Kampanye untuk mendukung atlet dan kegiatan olahraga'
            ],
            [
                'name' => 'Seni & Budaya',
                'description' => 'Kampanye untuk pelestarian seni dan budaya'
            ],
            [
                'name' => 'Keagamaan',
                'description' => 'Kampanye untuk kegiatan keagamaan dan pembangunan tempat ibadah'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
