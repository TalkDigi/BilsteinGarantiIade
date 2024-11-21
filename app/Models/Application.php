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
        'products' => 'array',
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
        'products',
        'BranchNo'
    ];

    const INPUT_MATCHES = [
            'car_brand' => 'Aracın Markası',
            'car_model' => 'Model Adı',
            'car_year' => 'Model Yılı',
            'car_number' => 'Şasi Numarası',
            'car_repair_date' => 'Onarımın (Montajın) Yapıldığı Tarih',
            'car_found_date' => 'Sorunun Veya Arızanın Tespit Edildiği Tarih',
            'car_found_milage' => 'Sorunun Veya Arızanın Tespit Edildiği Tarihte Aracın Kilometresi',
            'car_repair_milage' => 'Onarımın (Montajın) Yapıldığı Tarihte Aracın Kilometresi',
            'engine_power' => 'Motor Gücü (KW)',
            'engine_code' => 'Motor Kodu',
            'branch_name' => 'Perakendeci Adı',
            'branch_number' => 'Perakendeci Telefon Numarası',
            'service_name' => 'Onarımı Yapan Servis',
            'service_number' => 'Onarımı Yapan Servis Numarası',
            'customer_name' => 'Müşteri Adı',
            'customer_phone' => 'Müşteri Telefon Numarası',
            'customer_complain' => 'Müşteri Şikayeti',
            'fault' => 'Sorunla, Arızayla Veya Ürünle İlgili Detaylı Görüşleriniz',
            'invoice' => 'Servisin Müşteriye Kestiği İlk Fatura / İş Emri',
            'car_permit' => 'Araç Ruhsatı',
            'expense' => 'Masraf Proforma Faturası',
            'workmanship' => 'Harici İşçilik Faturası',
            'video' => 'Sorunu Anlatan Video',
            'gallery' => 'Sorunu Anlatan Görseller',
            'fault' => 'Parçaya Dair Arıza / Hata Görseli',
            'cost_request' => 'İlave Masraf'
    ];

    const CAT_INPUTS = [
    2 => [
        "files" => [
            'invoice',
            'car_permit',
            'expense',
            'workmanship',
            'video',
            'gallery',
        ],
        "application" => [
            'consent',
            'car_brand',
            'car_model',
            'car_year',
            'car_number',
            'car_repair_date',
            'car_repair_milage',
            'car_found_date',
            'car_found_milage',
            'engine_power',
            'engine_code',
            'branch_name',
            'branch_number',
            'service_name',
            'service_number',
            'customer_name',
            'customer_phone',
            'customer_complain',
            'fault',
            'cost_request',
        ],
    ],
    1 => [
        "files" => [
            'fault',
        ],
        "application" => [
            'consent',
            'car_brand',
            'car_model',
            'car_year',
            'car_number',
            'car_repair_date',
            'car_repair_milage',
            'car_found_date',
            'car_found_milage',
            'engine_power',
            'engine_code',
            'branch_name',
            'branch_number',
            'service_name',
            'service_number',
            'customer_name',
            'customer_phone',
            'customer_complain',
            'fault',
        ],
    ],
    3 => [
        "files" => [
            'fault',
        ],
        "application" => [
            'customer_complain',
            'fault',
        ],
    ],
];

    const LABELS = [
            "fault" => "Sorunla ilgili görüş",
            "car_year" => "Aracın yılı",
            "car_brand" => "Aracın markası",
            "car_model" => "Aracın modeli",
            "car_number" => "Aracın şasi numarası",
            "branch_name" => "Perakendeci adı",
            "service_name" => "Servis adı",
            "branch_number" => "Perakendeci numarası",
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

    public function productQuantities() {

        $total = 0;
        foreach($this->quantities as $quantity) {

            $total += $quantity;
        }

        return $total;
    }


    public function getType() {
        return Type::find($this->type);
    }


    public static function  getTotalStatusCounts($user_id = null) {

        $query = Application::groupBy('status')
            ->selectRaw('status, count(*) as count');



        if ($user_id !== null) {
            $query->where('user_id', $user_id);
        }

            $statusCounts = $query->get()->pluck('count', 'status');



        $groupedStatusCounts = [];

        $Statuses = Status::where('status',1)->get();

        //group by id
        $StatusesById = [];
        foreach ($Statuses as $key => $value) {
            $StatusesById[$value->id] = $statusCounts[$value->id] ?? 0;
        }

        foreach ($StatusesById as $key => $value) {

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

    public function getStatus() {
        return $this->belongsTo(Status::class, 'status');
    }

    //every application has user_id, its related to users. Every user has CustNo, its related to customers

    public function getUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'BranchNo', 'BranchID');
    }

}
