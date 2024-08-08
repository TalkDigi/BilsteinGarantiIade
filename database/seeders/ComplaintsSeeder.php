<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Complaint;
use App\Models\Type;

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
            $complaint = Complaint::create($item);
        }

        $relation = [
            [
                'complaint_id' => 1,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 2,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 3,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 4,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 5,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 9,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 10,
                'type_id' => 1,
            ],
            [
                'complaint_id' => 6,
                'type_id' => 3,
            ],
            [
                'complaint_id' => 7,
                'type_id' => 3,
            ],
            [
                'complaint_id' => 8,
                'type_id' => 3,
            ]
            ];

        foreach ($relation as $item) {
            $complaint = Complaint::find($item['complaint_id']);
            $complaint->types()->attach($item['type_id']);
        }



    }
}
