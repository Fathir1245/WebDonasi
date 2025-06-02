<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{
    /**
     * Menjalankan seeder database.
     */
    public function run(): void
    {
        // Mendapatkan semua ID pengguna kecuali admin
        $userIds = User::where('is_admin', false)->pluck('id')->toArray();
        
        // Mendapatkan semua kategori
        $categories = Category::all();
        
        // Data contoh kampanye
        $kampanye = [
            [
                'title' => 'Air Bersih untuk Desa Terpencil',
                'description' => 'Bantu kami menyediakan air bersih untuk desa-desa terpencil di Indonesia. Kampanye ini bertujuan untuk membangun sumur dan sistem penyaringan air di 5 desa, yang akan bermanfaat bagi lebih dari 1.000 orang. Akses ke air bersih akan meningkatkan kesehatan, mengurangi penyakit yang ditularkan melalui air, dan meningkatkan kualitas hidup masyarakat.',
                'target_amount' => 50000000,
                'deadline' => now()->addMonths(3),
                'status' => 'active',
                'category_id' => $categories->where('name', 'Lingkungan')->first()->id,
            ],
            [
                'title' => 'Pendidikan untuk Anak Kurang Mampu',
                'description' => 'Dukung pendidikan untuk anak-anak kurang mampu dengan menyediakan perlengkapan sekolah, seragam, dan beasiswa. Kampanye ini akan membantu 100 anak dari keluarga berpenghasilan rendah untuk melanjutkan pendidikan mereka dan membangun masa depan yang lebih baik. Donasi Anda akan langsung berdampak pada kehidupan mereka dan memberikan kesempatan yang layak mereka dapatkan.',
                'target_amount' => 75000000,
                'deadline' => now()->addMonths(6),
                'status' => 'active',
                'category_id' => $categories->where('name', 'Pendidikan')->first()->id,
            ],
            [
                'title' => 'Bantuan Medis untuk Lansia',
                'description' => 'Kampanye ini bertujuan untuk memberikan bantuan medis kepada lansia yang tidak mampu membayar perawatan kesehatan. Dana akan digunakan untuk obat-obatan, kunjungan dokter, dan prosedur medis yang diperlukan. Bantu kami memastikan bahwa para lansia menerima perawatan dan martabat yang layak di masa tua mereka.',
                'target_amount' => 100000000,
                'deadline' => now()->addMonths(2),
                'status' => 'active',
                'category_id' => $categories->where('name', 'Kesehatan')->first()->id,
            ],
            [
                'title' => 'Membangun Kembali Rumah Pasca Bencana Alam',
                'description' => 'Bantu membangun kembali rumah untuk keluarga yang terkena dampak gempa bumi baru-baru ini. Banyak keluarga telah kehilangan segalanya dan membutuhkan dukungan kita untuk membangun kembali kehidupan mereka. Donasi Anda akan langsung digunakan untuk bahan bangunan dan tenaga kerja untuk membangun rumah yang aman dan kokoh bagi keluarga yang kehilangan tempat tinggal.',
                'target_amount' => 200000000,
                'deadline' => now()->addMonths(4),
                'status' => 'active',
                'category_id' => $categories->where('name', 'Bencana Alam')->first()->id,
            ],
            [
                'title' => 'Proyek Kebun Komunitas',
                'description' => 'Dukung inisiatif kami untuk menciptakan kebun komunitas di lingkungan perkotaan. Kebun ini akan menyediakan hasil panen segar untuk keluarga lokal, menciptakan ruang hijau untuk pertemuan komunitas, dan mengajarkan praktik berkebun yang berkelanjutan. Bergabunglah dengan kami untuk menjadikan komunitas kita lebih hijau dan sehat!',
                'target_amount' => 25000000,
                'deadline' => now()->addMonths(2),
                'status' => 'active',
                'category_id' => $categories->where('name', 'Sosial')->first()->id,
            ],
        ];

        // Membuat direktori gambar placeholder jika belum ada
        if (!Storage::disk('public')->exists('campaigns')) {
            Storage::disk('public')->makeDirectory('campaigns');
        }

        // Membuat kampanye
        foreach ($kampanye as $index => $dataKampanye) {
            // Membuat nama gambar placeholder
            $namaGambar = 'campaigns/kampanye-' . ($index + 1) . '.jpg';
            
            // Membuat file gambar placeholder jika belum ada
            if (!Storage::disk('public')->exists($namaGambar)) {
                // Ini hanya placeholder. Dalam aplikasi nyata, Anda akan memiliki gambar sebenarnya.
                // Untuk saat ini, kita hanya membuat file kosong
                Storage::disk('public')->put($namaGambar, '');
            }
            
            // Memilih ID pengguna secara acak
            $userId = $userIds[array_rand($userIds)];
            
            // Menghitung jumlah dana terkumpul secara acak (antara 10% dan 90% dari target)
            $jumlahMinimal = $dataKampanye['target_amount'] * 0.1;
            $jumlahMaksimal = $dataKampanye['target_amount'] * 0.9;
            $jumlahTerkumpul = rand($jumlahMinimal, $jumlahMaksimal);
            
            // Membuat kampanye
            Campaign::create([
                'title' => $dataKampanye['title'],
                'description' => $dataKampanye['description'],
                'target_amount' => $dataKampanye['target_amount'],
                'current_amount' => $jumlahTerkumpul,
                'deadline' => $dataKampanye['deadline'],
                'image' => $namaGambar,
                'user_id' => $userId,
                'status' => $dataKampanye['status'],
                'category_id' => $dataKampanye['category_id'],
                'created_at' => now()->subDays(rand(1, 30)), // Tanggal pembuatan acak dalam sebulan terakhir
            ]);
        }
    }
}