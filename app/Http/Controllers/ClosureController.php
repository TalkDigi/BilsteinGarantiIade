<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class ClosureController extends Controller
{
    //

    public function index() {
        return view('dashboard.pages.closure');
    }

    public function filter(Request $request) {
        $month = $request->month;
        $year = $request->year;

        $data = Application::whereYear('created_at', $year)
                         ->whereMonth('created_at', $month)
                            ->whereIn('type', ['masraf-icermeyen-basvuru', 'hasarli-eksik-parca-bildirimi']) // Tip filtresi
                        ->where('user_id', auth()->id()) // Kullanıcı ID'si filtresi
                         ->get();

        //extract all quantities column from data. it has array in it. every key is a product. we need to store those ids in an array
        //then we'll query products table with those ids and get the products. then we'll get invoice with data's voice column. we'll append invoice to product
        $ids = [];
        foreach ($data as $item) {
            $ids = array_merge($ids, array_keys($item->quantities));
        }

        $Products = [];
        foreach($data as $d) {
            foreach($d->quantities as $key => $value) {

                $Product = Product::where('No',$key)->first();

                $Products[$d->claim_number]['products'][$key] = $Product;
                $Products[$d->claim_number]['quantities'][$key] = $value;
            }
            $Invoice = Invoice::where('InvoiceNo', $d->invoice)->first();
            $Products[$d->claim_number]['invoice'] = $Invoice;
        }

        return view('dashboard.pages.closure', compact('Products'));
    }

    public function process(Request $request)
    {
        $lines = $request->data;

        //sum total of all lines
        $total = 0;
        foreach($lines as $line) {
            $total += $line['price'] * $line['quantity'];
        }
        //calculate tax. its %20
        $tax = $total * 0.20;
        //calculate total with tax
        $total_with_tax = $total + $tax;
        $total_with_tax = number_format($total_with_tax, 2, '.', '');

        //render invoice view and response it
        $html = view('dashboard.pages.invoice', compact('lines', 'total', 'tax', 'total_with_tax'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);



    }
}
