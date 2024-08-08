<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            0 => [
                'html' => '<span class="badge badge-light">Taslak</span>',
                'slug' => 'taslak',
                'name' => 'Taslak',
                'color' => 'grey',
                'hasNotes' => false,
                'canEdit' => false,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => false,
                'noteRequired' => false
            ],
            1 => [
                'html' => '<span class="badge badge-primary">Değerlendiriliyor</span>',
                'slug' => 'degerlendiriliyor',
                'name' => 'Değerlendiriliyor',
                'color' => 'primary',
                'hasNotes' => false,
                'canEdit' => false,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => false,
                'noteRequired' => false
    
            ],
            2 => [
                'html' => '<span class="badge badge-info">Ön Onay Bekliyor</span>',
                'slug' => 'on-onay-bekleyenler',
                'name' => 'Ön Onay Bekliyor',
                'color' => 'info',
                'hasNotes' => false,
                'canEdit' => false,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => false,
                'noteRequired' => false
            ],
            3 => [
                'html' => '<span class="badge badge-success">Onaylandı</span>',
                'slug' => 'onaylandi',
                'name' => 'Onaylandı',
                'color' => 'success',
                'hasNotes' => true,
                'canEdit' => false,
                'showShipment' => true,
                'canInvoice' => true,
                'deleteBlocked' => false,
                'noteRequired' => false
            ],
            4 => [
                'html' => '<span class="badge badge-warning">Düzenleme İstendi</span>',
                'slug' => 'duzenleme-istendi',
                'name' => 'Düzenleme İstendi',
                'color' => 'warning',
                'hasNotes' => true,
                'canEdit' => true,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => false,
                'noteRequired' => false
            ],
            5 => [
                'html' => '<span class="badge badge-danger">Reddedildi</span>',
                'slug' => 'reddedildi',
                'name' => 'Reddedildi',
                'color' => 'danger',
                'hasNotes' => true,
                'canEdit' => false,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => true,
                'noteRequired' => false
            ],
            6 => [
                'html' => '<span class="badge badge-danger">Ön Onay & Kargo</span>',
                'slug' => 'on-onay-kargo',
                'name' => 'Ön Onay Verildi & Kargo Bekleniyor',
                'color' => 'info',
                'hasNotes' => false,
                'canEdit' => false,
                'showShipment' => false,
                'canInvoice' => false,
                'deleteBlocked' => true,
                'noteRequired' => false
                
            ],
        ];

        foreach ($statuses as $key => $status) {
            DB::table('statuses')->insert([
                'status' => 1,
                'html' => $status['html'],
                'slug' => $status['slug'],
                'name' => $status['name'],
                'color' => $status['color'],
                'hasNotes' => $status['hasNotes'],
                'noteRequired' => $status['noteRequired'],
                'canEdit' => $status['canEdit'],
                'showShipment' => $status['showShipment'],
                'canInvoice' => $status['canInvoice'],
                'deleteBlocked' => $status['deleteBlocked'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
