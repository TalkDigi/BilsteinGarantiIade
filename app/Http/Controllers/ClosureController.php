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
                            ->whereIn('type', ['masraf-icermeyen-basvuru', 'hasarli-parca-bildirimi']) // Tip filtresi
                            ->where('status', 3)
                            ->where('user_id', auth()->id()) // Kullanıcı ID'si filtresi
                            ->get();

        $items = [];

        foreach ($data as $products) {

            foreach ($products['products'] as $r) {
                $r['claim_number'] = $products->claim_number;
                $items[] = $r;
            }
        }

        return view('dashboard.pages.closure', compact('items'));
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
