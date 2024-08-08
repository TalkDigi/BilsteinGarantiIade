<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $to_create = [
            [
                'title' => 'İade',
                'slug' => 'iade',
                'view' => 'dashboard.pages.application.types.masraf-icermeyen-basvuru',
                'uuid' => Str::uuid(),
                'has_additional_payment' => false,
                'quantity_limitor' => 1,
            ],
            [
                'title' => 'İlave Masraf İçeren Başvuru',
                'slug' => 'ilave-masraf-iceren-basvuru',
                'view' => 'dashboard.pages.application.types.ilave-masraf-iceren-basvuru',
                'uuid' => Str::uuid(),
                'has_additional_payment' => true,
                'quantity_limitor' => 1,
            ],
            [
                'title' => 'Kutu İçeriği Eksik / Farklı / Hasarlı ',
                'slug' => 'eksik-farkli-hasarli',
                'view' => 'dashboard.pages.application.types.hasarli-eksik-parca-bildirimi',
                'uuid' => Str::uuid(),
                'has_additional_payment' => false,
                'quantity_limitor' => 0
            ],
        ];

        foreach ($to_create as $item) {
            \App\Models\Type::create($item);
        }
    }
}
