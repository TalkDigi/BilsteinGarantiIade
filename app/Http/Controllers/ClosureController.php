<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Closure;
use App\Models\Invoice;
use App\Models\Product;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Blockage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ClosureController extends Controller
{
    public $months = [
        1 => 'Ocak',
        2 => 'Şubat',
        3 => 'Mart',
        4 => 'Nisan',
        5 => 'Mayıs',
        6 => 'Haziran',
        7 => 'Temmuz',
        8 => 'Ağustos',
        9 => 'Eylül',
        10 => 'Ekim',
        11 => 'Kasım',
        12 => 'Aralık'
    ];

    public function index()
    {
        if (auth()->user()->hasRole('Yönetici')) {

            $ListClosures = Closure::all();

            $byYear = [];

            $invoices = [];

            foreach ($ListClosures as $Closure) {

                $byYear[$Closure->year][] = $Closure;

                if (!empty($Closure->data)) {
                    foreach ($Closure->data as $product) {
                        foreach ($product as $productItem) {
                            $invoiceNumbers[] = $productItem['invoice'];
                        }
                    }
                }

            }

            // Faturaları tek sorguda çekelim
            $invoices = Invoice::whereIn('ExDocNo', array_unique($invoiceNumbers))
                ->pluck('PostingDate', 'ExDocNo')
                ->toArray();

            $months = $this->months;

            return view('dashboard.pages.closure', compact('ListClosures', 'byYear', 'months', 'invoices'));
        }

        return view('dashboard.pages.closure');
    }

    public function show($uuid)
    {

        $Closure = Closure::where('uuid', $uuid)->first();
$months = $this->months;

$invoiceNumbers = [];

// Önce tüm fatura numaralarını toplayalım
if (!empty($Closure->data)) {
    foreach ($Closure->data as $claim => $closure) {
        foreach ($closure as $product) {
            $invoiceNumbers[] = $product['invoice'];
        }
    }
}

// Faturaları tek sorguda çekelim
$invoices = Invoice::whereIn('ExDocNo', array_unique($invoiceNumbers))
    ->pluck('PostingDate', 'ExDocNo')
    ->toArray();
        return view('dashboard.pages.closure-show', compact('Closure', 'months', 'invoices'));
    }

    public function filter(Request $request)
    {

        $onlyCustomer = true;


        //if user has role Yönetici
        if (auth()->user()->hasRole('Yönetici')) {
            $Closures = Closure::query();

            if ($request->CustNo) {
                $Closures = $Closures->where('CustNo', $request->CustNo);
            }

            if ($request->month) {
                $onlyCustomer = false;
                $Closures = $Closures->where('month', $request->month);
            }

            if ($request->year) {
                $onlyCustomer = false;
                $Closures = $Closures->where('year', $request->year);
            }

            $ListClosures = $Closures->get();

            // Gereksiz ikinci get() kaldırıldı

            $byYear = [];
            $invoiceNumbers = [];

            // İlk döngüde fatura numaralarını toplayalım
            foreach ($ListClosures as $Closure) {
                $byYear[$Closure->year][] = $Closure;

                if (!empty($Closure->data)) {
                    foreach ($Closure->data as $product) {
                        foreach ($product as $productItem) {
                            $invoiceNumbers[] = $productItem['invoice'];
                        }
                    }
                }
            }

            // Faturaları tek sorguda çekelim
            $invoices = Invoice::whereIn('ExDocNo', array_unique($invoiceNumbers))
                ->pluck('PostingDate', 'ExDocNo')
                ->toArray();

            $months = $this->months;

            return view('dashboard.pages.closure', compact('ListClosures', 'byYear', 'months', 'invoices', 'onlyCustomer'));
        }

        //if mont and year is not exist, return back
        if (!$request->month || !$request->year) {
            Session::flash('error', 'Ay ve yıl seçmelisiniz.');
            return back();
        }


        


        $month = (int)$request->month;
        $year = (int)$request->year;




        //check if aby closure exists for this month and year
        $Closure = Closure::where('month', $month)
            ->where('year', $year)
            ->where('CustNo', auth()->user()->CustNo)
            ->when(!empty(auth()->user()->BranchNo), function($query) {
                return $query->where('BranchNo', auth()->user()->BranchNo);
            })
            ->first();



        if ($Closure) {
            Session::flash('warning', 'Tamamlanmış bir ay kapama mevcut.');
            return redirect()->route('dashboard.application.closure-show', ['uuid' => $Closure->uuid]);
        }

        //get users all closures
        $Closures = Closure::where('CustNo', auth()->user()->CustNo)->get();

        


        $exist_applications = [];

        foreach ($Closures as $closure) {
            foreach ($closure->data as $claim => $data) {
                $exist_applications[] = $claim;
            }
        }



        $Applications = Application::whereNotIn('claim_number', $exist_applications)
            ->whereIn('type', [1, 3]) // Tip filtresi
            ->where('status', 5)
            ->where('user_id', auth()->id()) // Kullanıcı ID'si filtresi
            ->when(!empty(auth()->user()->BranchNo), function($query) {
                return $query->whereHas('user', function($q) {
                    $q->where('BranchNo', auth()->user()->BranchNo);
                });
            })
            ->get();



       // Önce tüm fatura numaralarını toplayalım
foreach ($Applications as $Application) {
    $applicationsByClaim[$Application->claim_number] = $Application;
    foreach ($Application->products as $product) {
        $invoiceNumbers[] = $product['invoice'];
    }
}

// Faturaları tek seferde çekelim
$invoices = Invoice::whereIn('ExDocNo', array_unique($invoiceNumbers))
    ->pluck('PostingDate', 'ExDocNo')
    ->toArray();



        return view('dashboard.pages.closure', compact('Applications', 'month', 'year', 'invoices', 'applicationsByClaim'));
    }

    public function process(Request $request)
    {


        //check if aby closure exists for this month and year
        $closure = Closure::where('month', $request->month)
            ->where('year', $request->year)
            ->where('CustNo', auth()->user()->CustNo)
            ->when(!empty(auth()->user()->BranchNo), function($query) {
                return $query->where('BranchNo', auth()->user()->BranchNo);
            })
            ->first();

        if ($closure) {
            Session::flash('error', 'Bu ay için kapanış işlemi zaten yapılmış.');
        }

        //get users other closures
        $Closures = Closure::where('CustNo', auth()->user()->CustNo)->get();


        $exist_applications = [];

        foreach ($Closures as $closure) {
            foreach ($closure->data as $claim => $data) {
                $exist_applications[] = $claim;
            }
        }


        $Applications = Application::whereNotIn('claim_number', $exist_applications)
            ->whereIn('type', [1, 3]) // Tip filtresi
            ->where('status', 5)
            ->where('user_id', auth()->id()) // Kullanıcı ID'si filtresi
            ->get();


        $data = [];
        $applicationsByClaim = [];


        foreach ($Applications as $application) {
            $applicationsByClaim[$application->claim_number] = $application;
            $data[$application->claim_number] = $application->products;

        }

        $closure = new Closure();
        $closure->uuid = \Str::uuid();
        $closure->month = $request->month;
        $closure->year = $request->year;
        $closure->CustNo = auth()->user()->CustNo;
        $closure->data = $data;
        if (!empty(auth()->user()->BranchNo)) {
            $closure->BranchNo = auth()->user()->BranchNo;
        }
        $closure->created_at = now();

        if ($closure->save()) {

            Session::flash('success','Kapanış işlemi başarıyla yapıldı.');
            return redirect()->route('dashboard.application.closure-show', ['uuid' => $closure->uuid]);
        } else {
            Session::flash('error', 'Kapanış işlemi sırasında bir hata oluştu.');
        }

    }

    public function create_invoice(Request $request)
    {

        $claim_number = $request->claim_number;

        $Application = Application::where('claim_number', $claim_number)->first();

        $lines = $Application->products;

        $total = 0;

        $target = null;

        if ($request->target === 'cost') {

            $target = 'cost';
            $total += $Application->application['accepted_cost'];
            $lines = [];

        } else {

            $target = 'item';
            foreach ($lines as $line) {
                $total += $line['price'] * $line['qty'];
            }

        }

        $tax = $total * 0.20;
        $total_with_tax = $total + $tax;
        $total_with_tax = number_format($total_with_tax, 2, '.', '');

        $html = view('dashboard.pages.invoice', compact('lines', 'total', 'tax', 'total_with_tax', 'Application', 'target'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);

    }

    public function export_invoice_closure($uuid)
    {
        $Closure = Closure::where('uuid', $uuid)->first();
        $data = $Closure->data;

        $total = 0;
        $brands = [];
        $lines = [];
        foreach ($data as $claim_number => $products) {
            foreach ($products as $line) {
                $total += $line['price'] * $line['qty'];
                $Product = Product::where('No', $line['code'])->first()->getBrand->brand;
                $brands[$line['code']] = $Product;
                $lines[] = $line;
            }
        }

        $tax = $total * 0.20;
        $total_with_tax = $total + $tax;
        $total_with_tax = number_format($total_with_tax, 2, '.', '');

        return Excel::download(new InvoiceExport($lines, $total, $tax, $total_with_tax, $data, $brands), 'kapanis-faturasi.xlsx');
    }

    public function export_invoice($claim_number,$type = null)
    {
        $Application = Application::where('claim_number', $claim_number)->first();
        $lines = $Application->products;

        $total = 0;
        $brands = [];
        foreach ($lines as $line) {
            $total += $line['price'] * $line['qty'];
            $Product = Product::where('No', $line['code'])->first()->getBrand->brand;
            $brands[$line['code']] = $Product;
        }

        if($type == 'cost') {
            if (isset($Application->application['accepted_cost'])) {
                $total = 0;
                $total += $Application->application['accepted_cost'];
            }
            $lines = [];
        }

        $tax = $total * 0.20;
        $total_with_tax = $total + $tax;
        $total_with_tax = number_format($total_with_tax, 2, '.', '');


        return Excel::download(new InvoiceExport($lines, $total, $tax, $total_with_tax, $Application, $brands,$type), $Application->claim_number . '-fatura.xlsx');
    }


    public function search_other_prices(Request $request)
    {

        //request should contain claim_number, and claim_number should be exist in database

        //check if claim_number exists in request

        if (!isset($request->claim_number)) {
            return response()->json([
                'success' => false,
                'message' => 'Hata.'
            ]);
        }

        //check if claim_number exists in database

        $Application = Application::where('claim_number', $request->claim_number)->first();

        if (!$Application) {
            return response()->json([
                'success' => false,
                'message' => 'Hata. Başvuru bulunamadı.'
            ]);
        }

        $product_code = $Application->products[0]['code'];
        $current_invoice = $Application->products[0]['invoice'];
        $product_quantity = $Application->products[0]['qty'];


        $Invoice = Invoice::where('CustNo', auth()->user()->CustNo)
    ->whereJsonContains('Line', [['ItemNo' => $product_code]])
    ->when(auth()->user()->customer->branches->count() > 0, function($query) {
        $branchIds = json_decode(auth()->user()->branch->Branches, true);
        return $query->whereIn('BranchID', $branchIds);
    })
    ->where('ExDocNo', '!=', $current_invoice)
    ->orderBy('PostingDate', 'desc')
    ->get();


        $searchString = 'ItemNo';

        $searchCode = $product_code;


        $products = [];

        foreach ($Invoice as $invoice) {

            $filteredLines = array_filter($invoice->Line, function ($line) use ($searchString, $searchCode) {

                return $line[$searchString] === $searchCode;

            });

            //filteredLines may hold more than one item, we need to iterate over it
            foreach ($filteredLines as $line) {

                $line['Price'] = $line['Amt'] / $line['Qty'];

                $line['Invoice'] = $invoice->ExDocNo;
                $line['PostingDate'] = $invoice->PostingDate;

                $products[] = $line;

            }
        }

        //check blockages
        foreach ($products as $key => &$product) {

            $blockage = Blockage::where('ItemNo', $product['ItemNo'])->where('InvoiceNo', $product['Invoice'])->get();

            $blocked_stock = 0;

            if ($blockage->count() > 0) {

                foreach ($blockage as $block) {

                    $blocked_stock += $block->Qty;

                }

                $product['Qty'] = $product['Qty'] - $blocked_stock;
                $product['Blocked'] = $blocked_stock;

                if ($product['Qty'] <= 0) {
                    unset($products[$key]);
                }

            }

        }

        Log::info('Products: ' . print_r($products, true));

        //send products to views.dashboard.elements.search-product and return it json with html
        return response()->json([

            'html' => view('dashboard.elements.search-product-closure', compact('products', 'Application', 'product_quantity'))->render()

        ]);

    }

    public function set_price(Request $request)
    {
        Log::info('Set price çalıştı');
        Log::info('Request' . print_r($request->all(), true));

        //Get application
        $Application = Application::where('claim_number', $request->claim_number)->first();

        if (!$Application) {
            return response()->json([
                'success' => false,
                'message' => 'Hata. Başvuru bulunamadı.'
            ]);
        }

        $product = $Application->products[$request->index];

        //get invoice now
        $Invoice = Invoice::where('ExDocNo', $request->invoice_id)->first();

        //Search $product['code'] in $Invoice->Line ItemNo
        $searchString = 'ItemNo';
        $searchCode = $product['code'];

        $filteredLines = array_filter($Invoice->Line, function ($line) use ($searchString, $searchCode) {

            return $line[$searchString] === $searchCode;

        });

        $new_product = array_values($filteredLines)[0];

        Log::info('Yeni ürün: ' . print_r($new_product, true));

        //First delete current blockage

        Log::info('product here' . print_r($product, true));

        $Blockage = Blockage::where('ItemNo', $product['code'])
            ->where('InvoiceNo', $product['invoice'])
            ->where('ClaimNo', $request->claim_number)
            ->whereRaw('CAST(Qty AS UNSIGNED) = ?', [$product['qty']])
            ->first();


        if (!$Blockage) {
            return response()->json([
                'success' => false,
                'message' => 'Hata. Blokaj bulunamadı.'
            ]);
        } else {
            $Blockage->InvoiceNo = $request->invoice_id;
            //save
            if (!$Blockage->save()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Hata. Blokaj değiştirilemedi.'
                ]);
            }
        }

        //now change current application products value
        /*[{"qty": "1", "code": 30533, "desc": "Radyatör kapağı", "price": 212.8871428571429, "invoice": "DSF2308665"}]*/
        $new_product_values = [
            'qty' => $product['qty'],
            'code' => $new_product['ItemNo'],
            'desc' => $new_product['ItemDesc'],
            'price' => $new_product['Amt'] / $new_product['Qty'],
            'invoice' => $request->invoice_id
        ];

        $current_products = $Application->products;
        //change index with new product values
        $current_products[$request->index] = $new_product_values;
        //set application products
        $Application->products = $current_products;


        if (!$Application->save()) {
            return response()->json([
                'success' => false,
                'message' => 'Hata. Başvuru kaydedilemedi.'
            ]);
        } else {
            $products = $current_products;
            return response()->json([
                'success' => true,
                'message' => 'Başvuru kaydedildi.',
                'html' => view('dashboard.elements.product-row-closure', compact('products', 'Application'))->render(),
                'claim' => $Application->claim_number
            ]);
        }


        die();

    }

}
