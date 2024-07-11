<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $to_create = [
            [
                'status' => 1,
                'title' => 'Ses Yapıyor'
            ],
            [
                'status' => 1,
                'title' => 'Titreme Yapıyor'
            ],
            [
                'status' => 1,
                'title' => 'Kaçırıyor'
            ],
            [
                'status' => 1,
                'title' => 'Çalışmıyor'
            ],
            [
                'status' => 1,
                'title' => 'Arıza Işığı Yanıyor'
            ],
            [
                'status' => 1,
                'title' => 'Ürün İçeriği Eksik'
            ],
            [
                'status' => 1,
                'title' => 'Ürün İçeriği Farklı'
            ],
            [
                'status' => 1,
                'title' => 'Ürün Kutudan Hasarlı Çıktı'
            ],
            [
                'status' => 1,
                'title' => 'Malzeme/Üretim Hatası'
            ],
            [
                'status' => 1,
                'title' => 'Yerine Oturmuyor'
            ],
        ];

        foreach ($to_create as $item) {
            \App\Models\Complaint::create($item);
        }

    }
}
