<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $casts = [
        'quantities' => 'array',
        'files' => 'array',
        'application' => 'array',
    ];

    protected $fillable = [
        'status',
        'editable',
        'type',
        'invoice',
        'quantities',
        'application',
        'files',
        'version',
        'rejected_by',
        'user_id',
    ];

    const FILE_MATCHES = [
        'invoice' => 'Müşteriye Kesilen Onarım Faturası',
        'car_permit' => 'Araç Ruhsatı',
        'work_order' => 'İş Emri',
        'expense' => 'Masraf Proforma Faturası',
        'workmanship' => 'Harici İşçilik Faturası',
        'video' => 'Sorunu Anlatan Video',
        'gallery' => 'Sorunu Anlatan Görseller',
        'consent' => 'İmzalı Parça Rıza Beyanı',
        'fault' => 'Parçaya Dair Arıza / Hata Görseli'
    ];

    const INT_TYPES = [
        'masraf-icermeyen-basvuru' => 1,
        'ilave-masraf-iceren-basvuru' => 2,
        'hasarli-eksik-parca-bildirimi' => 3,
    ];

    const STATUS = [
        0 => [
            'html' => '<span class="badge badge-light">Taslak</span>',
            'slug' => 'taslak',
            'name' => 'Taslak',
            'color' => 'grey',
            'hasNotes' => false,
            'canEdit' => false
        ],
        1 => [
            'html' => '<span class="badge badge-primary">Değerlendiriliyor</span>',
            'slug' => 'degerlendiriliyor',
            'name' => 'Değerlendiriliyor',
            'color' => 'primary',
            'hasNotes' => false,
            'canEdit' => false
        ],
        2 => [
            'html' => '<span class="badge badge-info">Ön Onay Bekliyor</span>',
            'slug' => 'on-onay-bekleyenler',
            'name' => 'Ön Onay Bekliyor',
            'color' => 'info',
            'hasNotes' => false,
            'canEdit' => false
        ],
        3 => [
            'html' => '<span class="badge badge-success">Onaylandı</span>',
            'slug' => 'onaylandi',
            'name' => 'Onaylandı',
            'color' => 'success',
            'hasNotes' => true,
            'canEdit' => false
        ],
        4 => [
            'html' => '<span class="badge badge-warning">Düzenleme İstendi</span>',
            'slug' => 'duzenleme-istendi',
            'name' => 'Düzenleme İstendi',
            'color' => 'warning',
            'hasNotes' => true,
            'canEdit' => true
        ],
        5 => [
            'html' => '<span class="badge badge-danger">Reddedildi</span>',
            'slug' => 'reddedildi',
            'name' => 'Reddedildi',
            'color' => 'danger',
            'hasNotes' => true,
            'canEdit' => false
        ],
    ];

    const TYPES= [

        'masraf-icermeyen-basvuru' => [
            'title' => 'Masraf İçermeyen Başvuru',
            'slug' => 'masraf-icermeyen-basvuru',
            'view' => 'dashboard.pages.application.types.masraf-icermeyen-basvuru',
        ],

        'ilave-masraf-iceren-basvuru' => [
            'title' => 'İlave Masraf İçeren Başvuru',
            'slug' => 'ilave-masraf-iceren-basvuru',
            'view' => 'dashboard.pages.application.types.ilave-masraf-iceren-basvuru',
        ],

        'hasarli-eksik-parca-bildirimi' => [
            'title' => 'Hasarlı / Eksik Parça Bildirimi',
            'slug' => 'hasarli-eksik-parca-bildirimi',
            'view' => 'dashboard.pages.application.types.hasarli-eksik-parca-bildirimi',
        ],

    ];

    const LABELS = [
            "fault" => "Sorunla ilgili görüş",
            "car_year" => "Aracın yılı",
            "car_brand" => "Aracın markası",
            "car_model" => "Aracın modeli",
            "car_number" => "Aracın şasi numarası",
            "branch_name" => "Bayi adı",
            "service_name" => "Servis adı",
            "branch_number" => "Bayi numarası",
            "customer_name" => "Müşterinin adı",
            "car_found_date" => "17/01/1995",
            "customer_phone" => "Mşterinin telefon numarası",
            "service_number" => "Servis numarası",
            "car_repair_date" => "16/01/1995",
            "car_found_milage" => "1000",
            "car_repair_milage" => "10000",
            "customer_complain" => "Müşteri şikayeti"
        ];

    public function generateClaimNumber()
    {
        return 'BL-' . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    public function productCount() {
        return count($this->quantities);
    }

    public function productQuantities() {

        $total = 0;
        foreach($this->quantities as $quantity) {

            $total += $quantity;
        }

        return $total;
    }

    public function getStatusBadge() {
        return self::STATUS[$this->status]['html'];
    }

    public function getStatusTitle() {
        return self::STATUS[$this->status]['name'];
    }

    public function getTypeTitle() {
        return self::TYPES[$this->type]['title'];
    }


    public static function  getTotalStatusCounts($user_id = null) {

        $query = Application::groupBy('status')
            ->selectRaw('status, count(*) as count');

        if ($user_id !== null) {
            $query->where('user_id', $user_id);
        }

            $statusCounts = $query->get()->pluck('count', 'status');


        $groupedStatusCounts = [];

        foreach (self::STATUS as $key => $value) {

            $groupedStatusCounts[$key] = $statusCounts[$key] ?? 0;

        }

        return $groupedStatusCounts;

    }



    public static function getStatusArray() {
        return self::STATUS;
    }

    public function getLocaleCreatedAtAttribute() {

        return $this->created_at->locale('tr')->isoFormat('D MMMM YYYY');

    }

    public function getProductDetails()
    {

        $quantities = $this->quantities;
        $productNos = array_keys($quantities);

        $products = Product::whereIn('No', $productNos)->get()->keyBy('No');

        $productDetails = [];
        foreach ($quantities as $productNo => $quantity) {

            if (isset($products[$productNo])) {

                $productDetails[] = [
                    'product' => $products[$productNo],
                    'quantity' => $quantity

                ];

            }

        }

        return $productDetails;

    }

    public function getFiles($key) {

        return isset($this->files[$key]) ? explode(',', $this->files[$key]) : [];

    }


}