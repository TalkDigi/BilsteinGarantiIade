<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function get_customer_branches(Request $request) {
        $customer_id = $request->customer_id;
       
        Log::info('Gelen customer_id: ' . $customer_id);

        $customer = Customer::where('No', $customer_id)->first();
        
        if (empty($customer)) {  // null kontrolü yerine empty() kullanalım
            return response()->json(['error' => 'Customer not found'], 404);
        }

        //get data from branches table, CustNo = $customer_id
        $branches = Branch::where('CustNo', $customer_id)->get();

        return response()->json(['branches' => $branches]);
    }
}
