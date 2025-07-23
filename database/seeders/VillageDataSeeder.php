<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageData;

class VillageDataSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        VillageData::truncate();

        $villageData = [
            // Geografi dan Lokasi
            [
                'type' => 'geografis',
                'label' => 'Luas Wilayah',
                'value' => '3.10',
                'description' => 'Luas wilayah dalam km² (7,23% dari total luas Kecamatan Ujungpangkah)',
                'icon' => 'fas fa-ruler-combined',
                'sort_order' => 1
            ],
            [
                'type' => 'geografis',
                'label' => 'Ketinggian',
                'value' => '3',
                'description' => 'Ketinggian di atas permukaan laut (meter)',
                'icon' => 'fas fa-mountain',
                'sort_order' => 2
            ],
            [
                'type' => 'geografis',
                'label' => 'Jarak ke Ibu Kota Kecamatan',
                'value' => '4',
                'description' => 'Jarak dari Desa Karangrejo ke Kecamatan Ujungpangkah (km)',
                'icon' => 'fas fa-road',
                'sort_order' => 3
            ],
            [
                'type' => 'geografis',
                'label' => 'Jarak ke Ibu Kota Kabupaten',
                'value' => '27',
                'description' => 'Jarak dari Desa Karangrejo ke Kabupaten Gresik (km)',
                'icon' => 'fas fa-location-arrow',
                'sort_order' => 4
            ],
            [
                'type' => 'geografis',
                'label' => 'Kategori Wilayah',
                'value' => 'Pesisir',
                'description' => 'Kategori wilayah berdasarkan letak geografis',
                'icon' => 'fas fa-water',
                'sort_order' => 5
            ],
            
            // Kependudukan
            [
                'type' => 'demografi',
                'label' => 'Jumlah Penduduk',
                'value' => '2,619',
                'description' => 'Total penduduk Desa Karangrejo (2023)',
                'icon' => 'fas fa-users',
                'sort_order' => 1
            ],
            [
                'type' => 'demografi',
                'label' => 'Jumlah Kepala Keluarga',
                'value' => '800',
                'description' => 'Total Kepala Keluarga (KK)',
                'icon' => 'fas fa-home',
                'sort_order' => 2
            ],
            [
                'type' => 'demografi',
                'label' => 'Kepadatan Penduduk',
                'value' => '861',
                'description' => 'Kepadatan penduduk per km²',
                'icon' => 'fas fa-chart-area',
                'sort_order' => 3
            ],
            [
                'type' => 'demografi',
                'label' => 'Penduduk Usia Produktif',
                'value' => '744',
                'description' => 'Penduduk usia 40-59 tahun',
                'icon' => 'fas fa-user-tie',
                'sort_order' => 4
            ],
            
            // Sosial dan Kesejahteraan
            [
                'type' => 'sosial',
                'label' => 'Jumlah Pasangan Menikah (2023)',
                'value' => '15',
                'description' => 'Jumlah pasangan yang menikah pada tahun 2023',
                'icon' => 'fas fa-heart',
                'sort_order' => 1
            ],
            [
                'type' => 'sosial',
                'label' => 'Peserta KB',
                'value' => '380',
                'description' => 'Total peserta Keluarga Berencana',
                'icon' => 'fas fa-baby',
                'sort_order' => 2
            ],
            [
                'type' => 'sosial',
                'label' => 'Sumber Air Minum',
                'value' => 'Sumur Pompa & Isi Ulang',
                'description' => 'Sumber air minum utama warga',
                'icon' => 'fas fa-tint',
                'sort_order' => 3
            ],
            
            // Ketenagakerjaan
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Penduduk Bekerja',
                'value' => '1,015',
                'description' => 'Jumlah penduduk yang bekerja',
                'icon' => 'fas fa-briefcase',
                'sort_order' => 1
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Mengurus Rumah Tangga',
                'value' => '548',
                'description' => 'Jumlah penduduk yang mengurus rumah tangga',
                'icon' => 'fas fa-home',
                'sort_order' => 2
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Pelajar/Mahasiswa',
                'value' => '493',
                'description' => 'Jumlah pelajar dan mahasiswa',
                'icon' => 'fas fa-graduation-cap',
                'sort_order' => 3
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Belum/Tidak Bekerja',
                'value' => '563',
                'description' => 'Jumlah penduduk yang belum/tidak bekerja',
                'icon' => 'fas fa-user-clock',
                'sort_order' => 4
            ],
            
            // Pertanian & Potensi
            [
                'type' => 'pertanian',
                'label' => 'Fokus Wilayah',
                'value' => 'Tambak & Pertanian Lahan Rendah',
                'description' => 'Fokus pengembangan wilayah',
                'icon' => 'fas fa-fish',
                'sort_order' => 1
            ],
            
            // Bencana dan Mitigasi
            [
                'type' => 'mitigasi',
                'label' => 'Fasilitas Mitigasi Bencana',
                'value' => 'Tidak Tersedia',
                'description' => 'Tidak memiliki fasilitas mitigasi bencana khusus',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 1
            ],
            
            // Administrasi Pemerintahan
            [
                'type' => 'pemerintahan',
                'label' => 'Kategori Desa',
                'value' => 'Desa Berkembang',
                'description' => 'Kategori desa di Kecamatan Ujungpangkah',
                'icon' => 'fas fa-flag',
                'sort_order' => 1
            ]
        ];

        // Masukkan data ke database
        foreach ($villageData as $data) {
            VillageData::create($data);
        }
                'type' => 'geografis',
                'label' => 'Luas Wilayah',
                'value' => '3.10',
                'description' => 'Luas wilayah dalam km² (7,23% dari total luas Kecamatan Ujungpangkah)',
                'icon' => 'fas fa-ruler-combined',
                'sort_order' => 1
            ],
            [
                'type' => 'geografis',
                'label' => 'Ketinggian',
                'value' => '3',
                'description' => 'Ketinggian di atas permukaan laut (meter)',
                'icon' => 'fas fa-mountain',
                'sort_order' => 2
            ],
            [
                'type' => 'geografis',
                'label' => 'Jarak ke Ibu Kota Kecamatan',
                'value' => '4',
                'description' => 'Jarak dari Desa Karangrejo ke Kecamatan Ujungpangkah (km)',
                'icon' => 'fas fa-road',
                'sort_order' => 3
            ],
            [
                'type' => 'geografis',
                'label' => 'Jarak ke Ibu Kota Kabupaten',
                'value' => '27',
                'description' => 'Jarak dari Desa Karangrejo ke Kabupaten Gresik (km)',
                'icon' => 'fas fa-location-arrow',
                'sort_order' => 4
            ],
            [
                'type' => 'geografis',
                'label' => 'Kategori Wilayah',
                'value' => 'Pesisir',
                'description' => 'Kategori wilayah berdasarkan letak geografis',
                'icon' => 'fas fa-water',
                'sort_order' => 5
            ],
            
            // Kependudukan
            [
                'type' => 'demografi',
                'label' => 'Jumlah Penduduk',
                'value' => '2,619',
                'description' => 'Total penduduk Desa Karangrejo (2023)',
                'icon' => 'fas fa-users',
                'sort_order' => 1
            ],
            [
                'type' => 'demografi',
                'label' => 'Jumlah Kepala Keluarga',
                'value' => '800',
                'description' => 'Total Kepala Keluarga (KK)',
                'icon' => 'fas fa-home',
                'sort_order' => 2
            ],
            [
                'type' => 'demografi',
                'label' => 'Kepadatan Penduduk',
                'value' => '861',
                'description' => 'Kepadatan penduduk per km²',
                'icon' => 'fas fa-chart-area',
                'sort_order' => 3
            ],
            [
                'type' => 'demografi',
                'label' => 'Penduduk Usia Produktif',
                'value' => '744',
                'description' => 'Penduduk usia 40-59 tahun',
                'icon' => 'fas fa-user-tie',
                'sort_order' => 4
            ],
            
            // Sosial dan Kesejahteraan
            [
                'type' => 'sosial',
                'label' => 'Jumlah Pasangan Menikah (2023)',
                'value' => '15',
                'description' => 'Jumlah pasangan yang menikah pada tahun 2023',
                'icon' => 'fas fa-heart',
                'sort_order' => 1
            ],
            [
                'type' => 'sosial',
                'label' => 'Peserta KB',
                'value' => '380',
                'description' => 'Total peserta Keluarga Berencana',
                'icon' => 'fas fa-baby',
                'sort_order' => 2
            ],
            [
                'type' => 'sosial',
                'label' => 'Sumber Air Minum',
                'value' => 'Sumur Pompa & Isi Ulang',
                'description' => 'Sumber air minum utama warga',
                'icon' => 'fas fa-tint',
                'sort_order' => 3
            ],
            
            // Ketenagakerjaan
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Penduduk Bekerja',
                'value' => '1,015',
                'description' => 'Jumlah penduduk yang bekerja',
                'icon' => 'fas fa-briefcase',
                'sort_order' => 1
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Mengurus Rumah Tangga',
                'value' => '548',
                'description' => 'Jumlah penduduk yang mengurus rumah tangga',
                'icon' => 'fas fa-home',
                'sort_order' => 2
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Pelajar/Mahasiswa',
                'value' => '493',
                'description' => 'Jumlah pelajar dan mahasiswa',
                'icon' => 'fas fa-graduation-cap',
                'sort_order' => 3
            ],
            [
                'type' => 'ketenagakerjaan',
                'label' => 'Belum/Tidak Bekerja',
                'value' => '563',
                'description' => 'Jumlah penduduk yang belum/tidak bekerja',
                'icon' => 'fas fa-user-clock',
                'sort_order' => 4
            ],
            
            // Pertanian & Potensi
            [
                'type' => 'pertanian',
                'label' => 'Fokus Wilayah',
                'value' => 'Tambak & Pertanian Lahan Rendah',
                'description' => 'Fokus pengembangan wilayah',
                'icon' => 'fas fa-fish',
                'sort_order' => 1
            ],
            
            // Bencana dan Mitigasi
            [
                'type' => 'mitigasi',
                'label' => 'Fasilitas Mitigasi Bencana',
                'value' => 'Tidak Tersedia',
                'description' => 'Tidak memiliki fasilitas mitigasi bencana khusus',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 1
            ],
            
            // Administrasi Pemerintahan
            [
                'type' => 'pemerintahan',
                'label' => 'Kategori Desa',
                'value' => 'Desa Berkembang',
                'description' => 'Kategori desa di Kecamatan Ujungpangkah',
                'icon' => 'fas fa-flag',
                'sort_order' => 1
            ]
                'label' => 'Ketinggian',
                'value' => '245 mdpl',
                'description' => 'Ketinggian rata-rata dari permukaan laut',
                'icon' => 'fas fa-mountain',
                'sort_order' => 4
            ],
            
            // Ekonomi
            [
                'type' => 'ekonomi',
                'label' => 'Petani',
                'value' => '65%',
                'description' => 'Persentase penduduk yang berprofesi sebagai petani',
                'icon' => 'fas fa-seedling',
                'sort_order' => 1
            ],
            [
                'type' => 'ekonomi',
                'label' => 'Pedagang',
                'value' => '20%',
                'description' => 'Persentase penduduk yang berprofesi sebagai pedagang',
                'icon' => 'fas fa-store',
                'sort_order' => 2
            ],
            [
                'type' => 'ekonomi',
                'label' => 'PNS/TNI/POLRI',
                'value' => '10%',
                'description' => 'Persentase penduduk yang bekerja sebagai PNS/TNI/POLRI',
                'icon' => 'fas fa-user-tie',
                'sort_order' => 3
            ],
            [
                'type' => 'ekonomi',
                'label' => 'Lainnya',
                'value' => '5%',
                'description' => 'Persentase penduduk dengan profesi lainnya',
                'icon' => 'fas fa-briefcase',
                'sort_order' => 4
            ],
        ];

        foreach ($villageData as $data) {
            VillageData::create($data);
        }
    }
}