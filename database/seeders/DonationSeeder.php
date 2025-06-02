<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DonationSeeder extends Seeder
{
    /**
     * Menjalankan seeder database.
     */
    public function run(): void
    {
        // Mendapatkan semua kampanye
        $kampanye = Campaign::all();
        
        // Mendapatkan semua ID pengguna
        $userIds = User::pluck('id')->toArray();
        
        // Metode pembayaran
        $metodePembayaran = ['credit_card', 'bank_transfer', 'e-wallet'];
        
        // Contoh pesan
        $pesan = [
            'Teruslah melakukan pekerjaan baik!',
            'Senang bisa membantu untuk tujuan ini.',
            'Semoga sukses dengan kampanye ini.',
            'Ini adalah inisiatif yang sangat penting.',
            'Semoga ini membantu!',
            null, // Beberapa donasi mungkin tidak memiliki pesan
        ];
        
        // Untuk setiap kampanye, buat beberapa donasi
        foreach ($kampanye as $kampanyeItem) {
            // Jumlah donasi untuk kampanye ini (5-15)
            $jumlahDonasi = rand(5, 15);
            
            // Melacak total donasi untuk memastikan tidak melebihi current_amount
            $totalDonasi = 0;
            
            for ($i = 0; $i < $jumlahDonasi; $i++) {
                // Lewati jika kita sudah mencapai atau melebihi jumlah terkumpul
                if ($totalDonasi >= $kampanyeItem->current_amount) {
                    break;
                }
                
                // Menghitung jumlah donasi secara acak
                $maksimalDonasi = $kampanyeItem->current_amount - $totalDonasi;
                $minimalDonasi = min(10000, $maksimalDonasi); // Minimal 10.000 atau sisa yang tersedia
                $maksimalJumlahDonasi = min(5000000, $maksimalDonasi); // Maksimal 5.000.000 atau sisa yang tersedia
                
                // Memastikan kita memiliki rentang yang valid
                if ($minimalDonasi >= $maksimalJumlahDonasi) {
                    $jumlah = $maksimalDonasi;
                } else {
                    $jumlah = rand($minimalDonasi, $maksimalJumlahDonasi);
                }
                
                // Memperbarui total donasi
                $totalDonasi += $jumlah;
                
                // Memilih pengguna secara acak
                $userId = $userIds[array_rand($userIds)];
                
                // Memilih metode pembayaran secara acak
                $metodePembayaranTerpilih = $metodePembayaran[array_rand($metodePembayaran)];
                
                // Memilih pesan secara acak atau null
                $pesanTerpilih = $pesan[array_rand($pesan)];
                
                // Membuat ID transaksi
                $idTransaksi = 'TRX-' . Str::upper(Str::random(8));
                
                // Membuat donasi
                Donation::create([
                    'amount' => $jumlah,
                    'message' => $pesanTerpilih,
                    'user_id' => $userId,
                    'campaign_id' => $kampanyeItem->id,
                    'status' => 'completed',
                    'payment_method' => $metodePembayaranTerpilih,
                    'transaction_id' => $idTransaksi,
                    'created_at' => now()->subDays(rand(1, 30)), // Tanggal pembuatan acak dalam sebulan terakhir
                ]);
            }
        }
    }
}