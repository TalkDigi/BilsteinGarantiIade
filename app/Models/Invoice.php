<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Invoice extends Model
{
    use HasFactory;

    protected $connection = 'mysqlSource';
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

    public function getLines()
    {
        $lines = $this->Line;
        return isset($lines[0]) && is_array($lines[0]) ? $lines : [$lines];
    }

    public function updateLinesWithBrandNames()
    {
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

    public function getItemPrice()
    {
        $Lines = $this->getLines(); // Mevcut getLines fonksiyonunu kullanarak satırları alıyoruz.
        $prices = [];

        foreach ($Lines as $line) {

            $price = $line['Amt'] / $line['Qty'];

            $prices[$line['ItemNo']] = $price;
        }

        return $prices;
    }

    public static function checkInvoice($custNo, $itemNo, $basvuruAdedi)
    {

        Log::info('checkInvoice', ['custNo' => $custNo, 'itemNo' => $itemNo, 'basvuruAdedi' => $basvuruAdedi]);

        $invoices = Invoice::where('CustNo', $custNo)->whereJsonContains('Line', [['ItemNo' => $itemNo]])->orderBy('PostingDate', 'desc')->get();

        if($invoices->isEmpty()) {

            return [
                'success' => false,
                'message' => 'Ürüne ait uygun fatura bulunamadı. Lütfen ürün kodunu kontrol ediniz.'
            ];

        }

        $totalQty = 0;

        $totalBlockageQty = 0;

        foreach ($invoices as $invoice) {

            $line = collect($invoice->Line)->firstWhere('ItemNo', $itemNo);

            if ($line) {

                $totalQty += $line['Qty'];

                $blockages = Blockage::where('InvoiceNo', $invoice->ExDocNo)->get();

                //eğer blokaj varsa toplam blokaj miktarını hesapla

                if(!$blockages) {
                    $totalBlockageQty += $blockages->sum('Qty');
                }
            }
        }

        if (($totalQty - $totalBlockageQty) < $basvuruAdedi) {

            return [
                'success' => false,
                'message' => 'Başvuru adedini karşılayacak satın alım bulunamadı.'
            ];

        }

        $remainingQty = $basvuruAdedi;

        $result = [];

        foreach ($invoices as $invoice) {

            $line = collect($invoice->Line)->firstWhere('ItemNo', $itemNo);

            if ($line) {

                $invoiceQty = $line['Qty'];

                $blockages = Blockage::where('InvoiceNo', $invoice->ExDocNo)->get();

                $totalBlockageQty = $blockages->sum('Qty');

                $availableQty = $invoiceQty - $totalBlockageQty;

                if ($availableQty > 0) {

                    if ($remainingQty <= $availableQty) {

                        $result[] = [
                            'invoice' => $invoice->ExDocNo,
                            'posting_date' => $invoice->PostingDate,
                            'line' => $line,
                            'usedQty' => $remainingQty
                        ];

                        $remainingQty = 0;

                        break;

                    } else {

                        $result[] = [
                            'invoice' => $invoice->ExDocNo,
                            'posting_date' => $invoice->PostingDate,
                            'line' => $line,
                            'usedQty' => $availableQty
                        ];

                        $remainingQty -= $availableQty;

                    }
                }
            }
        }


        if ($remainingQty > 0) {

            return [
                'success' => false,
                'message' => 'Yeterli miktarda uygun fatura bulunamadı.'
            ];

        }


        return [
            'success' => true,
            'result' => $result
        ];
    }
}
