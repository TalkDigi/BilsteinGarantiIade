<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'InvoiceNo',
        'CustNo',
        'Branch',
        'BranchID',
        'PostingDate',
        'ExDocNo',
        'Amt',
        'AmtIncVAT',
        'Line',
    ];

    protected $casts = [
        'Line' => 'array',
    ];

    public function getLines() {
        $lines = $this->Line;
        return isset($lines[0]) && is_array($lines[0]) ? $lines : [$lines];
    }

    public function updateLinesWithBrandNames() {
        $Lines = $this->getLines(); // Mevcut getLines fonksiyonunu kullanarak satırları alıyoruz.
        $ItemNo = [];
        foreach ($Lines as $line) {
            $ItemNo[] = $line['ItemNo'];
        }

        // Product modelini kullanarak ilgili ürün numaralarına göre ürünleri çekiyoruz.
        $Product = \App\Models\Product::whereIn('No', $ItemNo)->get();
        $Product = $Product->pluck('BrandName', 'No');

        // Satırları döngüye alıp, eğer ürün numarası Product koleksiyonunda varsa, ilgili marka adını satıra ekliyoruz.
        foreach ($Lines as $key => $line) {
            if (isset($Product[$line['ItemNo']])) {
                $Lines[$key]['BrandName'] = $Product[$line['ItemNo']];
            }
        }

        return $Lines; // Güncellenmiş satırları dönüyoruz.
    }

    public function getItemPrice() {
        $Lines = $this->getLines(); // Mevcut getLines fonksiyonunu kullanarak satırları alıyoruz.
        $prices = [];

        foreach($Lines as $line) {

            $price = $line['Amt'] / $line['Qty'];

            $prices[$line['ItemNo']] = $price;
        }

        return $prices;
    }

}
