<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Complaint;
use App\Models\Invoice;
use App\Models\Quantity;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Blockage;
use Illuminate\Support\Str;
use PDF;
use App\Models\Closure;
class ApplicationController extends Controller
{

    public function list($type = null, $tip = null)
    {

        //get all closures
        $Closures = Closure::all();

        //in closure data column there is a data like this.
        // {"BL-22CA1A": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}]}
        //or something like this
        // {"BL-22CA1A": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}], "BL-22CA1Z": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}]}
        //and it has year,month columns
        //for exp. find BL-22CA1A inside applications -> claim_number. add month year and uuid form closures to applications

        //loop every closures, create new array. bl-22ca1a should be key of array. value of array is month and year  and uuid of closure.
        $FilteredClosures = [];
        foreach ($Closures as $Closure) {

            foreach ($Closure->data as $key => $value) {
                $FilteredClosures[$key] = [
                    'month' => $Closure->month,
                    'year' => $Closure->year,
                    'uuid' => $Closure->uuid
                ];
            }
        }

        

        $Types = Type::all();

        $basvuru_turu = 'tumu';

        if (Auth::user()->hasRole('Yönetici')) {

            $query = Application::query();
            $statusCounts = Application::getTotalStatusCounts();

        } elseif(Auth::user()->hasRole('Şube Yöneticisi')) {

            $query = Application::whereHas('getUser', function($query) {
                $query->where('CustNo', auth()->user()->CustNo);
            });


            $statusCounts = Application::getTotalStatusCounts();

        } else {

            $query = Application::where('user_id', auth()->id());

            $statusCounts = Application::getTotalStatusCounts(auth()->id());
        }

        if ($type !== null) {
            if ($type !== 'tumu') {
                $query->where('type', $type);
            }
            $basvuru_turu = $type;
        }

        if ($tip !== null) {

            if ($tip !== 'tumu') {
                $Status = Status::where('slug', $tip)->first();

                $query->where('status', $Status->id);
            }
        }

        $Applications = $query->orderBy('id', 'desc')->get();



        return view('dashboard.pages.application.index', compact('Applications', 'statusCounts', 'tip', 'basvuru_turu', 'Types','FilteredClosures'));

    }

    public function index()
    {
        return view('dashboard.pages.application.first');
    }

    public function search(Request $request)
    {

        $result = [];

        //check if $request->uuid is exist and valid uuid

        if (!$request->has('uuid') || Str::isUuid($request->uuid) === false) {
            Log::info('step1');
            return redirect()->route('dashboard');
        }

        $Type = Type::where('uuid', $request->uuid)->first();

        if (!$Type) {
            Log::info('step2');
            return redirect()->route('dashboard');
        }


        $application_quantity = null;

        $productCode = $request->productCode;

        // Ürün kodunun uzunluğunu kontrol et ve gerekirse düzelt
        if (strlen($request->productCode) == 4) {
            $productCode = '0' . $productCode;
        } 

        if ($Type->quantity_limitor) {
            //check quantitiy which imported

            $Quantity = Quantity::where('ItemNo', $productCode)->first();

            if ($Quantity) {
                Log::info('step4');
                $application_quantity = $Quantity->unit;
            } else {
                Log::info('step5');
                $application_quantity = $Type->quantity_limitor;
            }

            $result['hide_search'] = true;

        } else {
            $result['hide_search'] = false;
            $application_quantity = $request->productCount;
        }


        $filtered_products = Invoice::checkInvoice(auth()->user(), $productCode, $application_quantity);

        Log::info('step6');
        if ($filtered_products['success'] === false) {
            Log::info('step7');
            return response()->json([
                'success' => false,
                'message' => $filtered_products['message']
            ]);
        } else {
            Log::info('step8');
            $result['success'] = true;
        }

        Log::info('Filtered products', ['products' => $filtered_products]);

        $result['html'] = view('dashboard.elements.search-product', ['products' => $filtered_products['result']])->render();

        return response()->json(
            $result
        );

    }

    public function show($claim)
    {



        $Application = Application::where('claim_number', $claim)->first();

        if (!$Application) {

            return redirect()->route('dashboard');

        }

        if (auth()->user()->hasRole('Yönetici')) {

            $Application = Application::where('claim_number', $claim)->first();
            if (!$Application->getStatus->canEdit) {
                $Application->editable = 0;
            }
            $Application->viewed_by = auth()->id();
            $Application->save();

        }

        $Logs = Activity::whereJsonContains('properties->claim', $Application->claim_number)->orderBy('id', 'desc')->limit(10)->get();

        $Status = Status::where('status', 1)->where('id', $Application->status)->first();


        if (!$Status) {
            //return dashboard
            return redirect()->route('dashboard');
        }

        $Message = null;

        $Files = null;

        if ($Status->hasNotes) {

            $lastActivity = Activity::where('event', 'application-status-update')->whereJsonContains('properties->claim', $Application->claim_number)->orderBy('id', 'desc')->first();

            $Message = $lastActivity->properties['message'] ?? null;

            $Files = $lastActivity->properties['files'] ?? null;

        }

        $Labels = Application::LABELS;

        $FileMatches = Application::INPUT_MATCHES;
        $CatInputs = Application::CAT_INPUTS[$Application->type];

        $brands = [];

        foreach ($Application->products as $product) {
            $Product = Product::where('No', $product['code'])->first()->getBrand->brand;
            $brands[$product['code']] = $Product;
        }


        return view('dashboard.pages.application.show', compact('Application', 'Logs', 'Status', 'Message', 'Files', 'Labels', 'FileMatches', 'brands', 'CatInputs'));

    }

    public function update_status($status, $claim_number)
    {

        $Application = Application::where('claim_number', $claim_number)->first();

        if (!$Application) {

            return redirect()->route('dashboard');

        }

        if ($Application->status == $status) {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Başvuru zaten değiştirmek istediğiniz duruma sahip.']);

        }


        $Application->status = $status;

        if($status == 3) {
            $Application->cargo_history = true;
        }

        $Status = Status::where('id', $status)->first();

        if ($Application->save()) {

            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties(['claim' => $Application->claim_number])
                ->event('application-status-update')
                ->log(auth()->user()->name . ', ' . $Application->claim_number . ' numaralı başvurunun durumunu ' . $Status->html . ' olarak güncelledi.');

            Session::flash('success', 'Durum güncellendi.');

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

        } else {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bir hata oluştu.']);

        }

    }

    public function edit($claim)
    {

        $Application = Application::where('claim_number', $claim)->first();


        if (!$Application) {

            return redirect()->route('dashboard');

        }

        if (!$Application->editable) {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bu başvuru durumu düzenlenemez.']);

        }

        $lastActivity = Activity::where('subject_id', $Application->id)->where('event', 'application-status-update')->whereJsonContains('properties->claim', $Application->claim_number)->whereJsonContains('properties->new_status', "4")->orderBy('id', 'desc')->first();

        $inputs = null;

        if (isset($lastActivity->properties['inputs'])) {
            $inputs = $lastActivity->properties['inputs'];
        }

        debug($inputs);

        $Invoice = Invoice::where('InvoiceNo', $Application->invoice)->first();

        $Type = Type::where('id', $Application->type)->first();

        $allinputs = Application::INPUT_MATCHES;

        return view($Type->view, compact('Application', 'Invoice', 'Type', 'inputs', 'allinputs'));
    }

    public function update_status_with_message(Request $request)
    {

        $status = Status::where('id', $request->new_status)->first();

        if ($status->deleteBlocked) {

            $Blockages = Blockage::where('ClaimNo', $request->claim_number)->get();

            foreach ($Blockages as $Blockage) {
                $Blockage->delete();
            }
        }


        $Application = Application::where('claim_number', $request->claim_number)->first();

        if (!$Application) {

            return redirect()->route('dashboard');

        }


        if ($Application->status == $request->new_status) {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Başvuru zaten değiştirmek istediğiniz duruma sahip.']);

        }

        $Application->status = $request->new_status;


        if ($status->canEdit) {
            $Application->editable = true;
        } else {
            $Application->editable = false;
        }

        //we have a json inside $Application->application. if request has accepted_costs, save it to application json. also this column casted as array.


        if ($request->has('accepted_cost')) {
            $applicationData = $Application->application;
            if (isset($applicationData['cost_request'])) {
                $newApplicationData = [];
                foreach ($applicationData as $key => $value) {
                    $newApplicationData[$key] = $value;
                    if ($key === 'cost_request') {
                        $newApplicationData['accepted_cost'] = $request->accepted_cost;
                    }
                }
                $applicationData = $newApplicationData;

            } else {
                $applicationData['accepted_cost'] = $request->accepted_cost;
            }

            $Application->application = $applicationData;
        }

        if ($Application->save()) {

            if ($request->new_status == 5) {
                //update application confirmed_at
                $Application->confirmed_at = date('Y-m-d H:i:s');
                $Application->save();
            }


            $inputs = null;

            if ($request->has('inputs')) {
                $inputs = $request->inputs;
            }

            $props = [
                'claim' => $Application->claim_number,
                'message' => $request->message,
                'new_status' => $request->new_status,
                //if request has inputs
                'inputs' => $inputs
            ];

            if ($request->has('files.support')) {
                //this input may be has more than one file. if its so, it includes , on this string.
                //check if text has , in it, if it is explode it and save it as array
                //if its not, save support value inside array
                $files = explode(',', $request->input('files.support'));
                $props['files'] = $files;

            }

            $Status = Status::where('id', $request->new_status)->first();

            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties($props)
                ->event('application-status-update')
                ->log(auth()->user()->name . ', ' . $Application->claim_number . ' numaralı başvurunun durumunu ' . $Status->html . ' olarak güncelledi.');

            Session::flash('success', 'Durum güncellendi.');

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

        } else {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bir hata oluştu.']);

        }

    }

    public function firstStep($type = null)
    {

        try {

            $Complaints = Complaint::where('status', 1)->get();

            $Type = Type::where('slug', $type)->first();

            return view($Type->view, compact('Type', 'Complaints'));


        } catch (\Exception $e) {

            Log::error($e->getMessage());

            if (!app()->isProduction()) {

                dd($e->getMessage());

            } else {

                Log::error('Bridge işleminde hata oluştu');
                Log::error($e->getMessage());

                return redirect()->route('dashboard');

            }
        }
    }


    public function store($type, Request $request)
    {




        //check if request->uuid is exist and valid uuid
        if (!$request->has('uuid') || Str::isUuid($request->uuid) === false) {


            return response()->json([
                'success' => false,
                'message' => 'Lütfen geçerli bir tipte başvuru yapın.'
            ]);


        }

        $Type = Type::where('uuid', $request->uuid)->first();

        if (!$Type) {

            return response()->json([
                'success' => false,
                'message' => 'Lütfen geçerli bir tipte başvuru yapın.'
            ]);

        }

        if (!$request->has('products') || empty($request->products)) {

            Log::info('Products check' . print_r($request->products, true));

            return response()->json([
                'success' => false,
                'message' => 'Lütfen ürün seçiniz.'
            ]);

        }

        $products = json_decode($request->products);

        $productsByKey = collect($products)->keyBy('invoice');

        $codes = [];

        foreach ($products as $product) {
            if (!in_array($product->code, $codes)) {
                $codes[] = $product->code;
            }
        }

        $quantities = [];

        foreach ($products as $product) {
            if (isset($quantities[$product->code])) {
                $quantities[$product->code] = $quantities[$product->code] + $product->qty;
            } else {
                $quantities[$product->code] = $product->qty;
            }
        }


        $CompareData = [];

        foreach ($quantities as $no => $quantity) {
            $no = (string) $no;
            $check_invoice = Invoice::checkInvoice(auth()->user(), $no, $quantity);

            if ($check_invoice['success'] === false) {
                return response()->json([
                    'success' => false,
                    'message' => $check_invoice['message']
                ]);
            } else {
                foreach ($check_invoice['result'] as $result) {
                    if (!isset($CompareData[$result['invoice']])) {
                        $CompareData[$result['invoice']] = [];
                    }
                    $CompareData[$result['invoice']][] = $result;
                }
            }
        }

        foreach ($products as $product) {
            $invoiceLines = $CompareData[$product->invoice];
            $matchingLine = null;

            

            foreach ($invoiceLines as $line) {
                Log::info('Ürün'.print_r($product,true));
                if ($line['line']['ItemNo'] == $product->code && $line['line']['LineNumber'] == $product->line) {
                    $matchingLine = $line;
                    break;
                }
            }

            if (!$matchingLine) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ürün bulunamadı. Ürün kodu: ' . $product->code
                ]);
            }

            $price = number_format($matchingLine['line']['Amt'] / $matchingLine['line']['Qty'], 2, '.', '');


            if ($price != $product->price) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ürün fiyatı hatalı. Ürün kodu: ' . $product->code
                ]);
            }

            if ($matchingLine['usedQty'] != $product->qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stokta yeterli ürün bulunmamaktadır. Ürün kodu: ' . $product->code
                ]);
            }
        }

        if (isset($request->application['consent'])) {
            $application = $request->application;
            foreach ($application['consent'] as $key => $value) {
                $application['consent'][$key] = 1;
            }
            $request->merge(['application' => $application]);
        }

        $Application = new Application();
        $Application->status = 2;
        $Application->editable = 1;
        $Application->type = $Type->id;
        $Application->application = $request->application;
        $Application->files = $request->docs;
        $Application->version = 1;
        $Application->quantities = [];
        $Application->user_id = auth()->id();
        $Application->claim_number = $Application->generateClaimNumber();
        $Application->products = $products;
        if (!empty(auth()->user()->BranchNo)) {
            $Application->BranchNo = auth()->user()->BranchNo;
        }

        if ($Application->save()) {

            Session::flash('claim_number', $Application->claim_number);

            //Create blockages
            $blockages = [];

            Log::info('Gelen ürünler burada'.print_r($products,true));
            foreach ($products as $product) {
                $blockages[] = [
                    'InvoiceNo' => $product->invoice,
                    'ItemNo' => $product->code,
                    'Qty' => $product->qty,
                    'ClaimNo' => $Application->claim_number,
                    'line' => $product->line,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }

            $blockage = new Blockage();
            $blockage->insert($blockages);


            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties(['claim' => $Application->claim_number])
                ->event('application-create')
                ->log(auth()->user()->name . ', ' . $Application->claim_number . ' numaralı başvuruyu oluşturdu.');


            //TODO - Başvuru listeleme sayfasına yönlendir.

            Log::info('Redirect edilen link' . route('dashboard.application.show', ['claim' => $Application->claim_number]));
            return response()->json([
                'success' => true,
                'message' => 'Başvuru oluşturuldu.',
                'redirect' => route('dashboard.application.show', ['claim' => $Application->claim_number])
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu. Lütfen sayfayı yenileyerek tekrar deneyin.'
            ]);

        }

    }

    public function update($claim, Request $request)
    {
        $Application = Application::where('claim_number', $claim)->first();

        if (!$Application) {
            return redirect()->route('dashboard');
        }

        if ($Application->status != 0) {
            if (!$Application->editable) {
                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bu başvuru düzenlenemez.']);
            }
        }

        $Application->status = 2;
        $Application->application = $request->application;

        // Mevcut dosyaları koru ve sadece yeni gelen dosyaları güncelle
        $currentFiles = $Application->files ?? [];
        $newFiles = $request->docs ?? [];
        
        // Her bir dosya tipi için kontrol et
        foreach ($newFiles as $fileType => $fileValue) {
            // Eğer yeni bir dosya geldi ise güncelle, gelmediyse mevcut dosyayı koru
            if (!is_null($fileValue)) {
                $currentFiles[$fileType] = $fileValue;
            }
        }

        $Application->files = $currentFiles;
        $Application->version = $Application->version + 1;

        if ($Application->save()) {
            Session::flash('success', 'Güncellendi.');

            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties(['claim' => $Application->claim_number])
                ->event('application-content-update')
                ->log(auth()->user()->name . ', ' . $Application->claim_number . ' numaralı başvurunun içeriğini güncelledi.');

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);
        } else {
            return redirect()->back()->withInput($request->all())->withErrors(['Bir hata oluştu.']);
        }
    }


    public function applicationBridge(Request $request)
    {

        //check if request->uuid is exist and valid uuid
        if (!$request->has('application_type') || Str::isUuid($request->application_type) === false) {

            return redirect()->route('dashboard');

        }

        //check if uuid is exist in Type
        $Type = Type::where('uuid', $request->application_type)->first();

        if (!$Type) {

            return redirect()->route('dashboard');

        }


        return redirect()->route('dashboard.application.firstStep', ['type' => $Type->slug]);

    }

    public function invoiceIndex($type, $page = 1)
    {

        if (!array_key_exists($type, Application::TYPES)) {

            return redirect()->route('dashboard');

        }

        $type = Application::TYPES[$type];

        //TODO CustNo parametresi dinamik olacak
        $Invoices = Invoice::where('CustNo', '120.1050')->orderBy('id', 'desc')->get();

        return view('dashboard.pages.application.invoice-list', compact('Invoices', 'type'));

    }


    public function calculatePrice($data)
    {


        $Products = [];
        foreach ($data->quantities as $key => $value) {

            $Product = Product::where('No', $key)->first();

            $Products['products'][$key] = $Product;
            $Products['quantities'][$key] = $value;
        }
        $Invoice = Invoice::where('InvoiceNo', $data->invoice)->first();
        $Products['invoice'] = $Invoice;
        return $Products;
    }

    public function generatePDF($claim_number)
    {

        $Application = Application::where('claim_number', $claim_number)->first();

        $html = view('dashboard.pages.application.pdf', compact('Application'))->render();

        $pdf = PDF::loadHTML($html);

        return $pdf->download($Application->claim_number . '.pdf');

    }

    public function claim_search(Request $request)
    {

        $Types = Type::all();
        
        $basvuru_turu = 'tumu';
        $tip = 'tumu';

        if (Auth::user()->hasRole('Yönetici')) {
            $query = Application::query();
            $statusCounts = Application::getTotalStatusCounts();
        }elseif(Auth::user()->hasRole('Şube Yöneticisi')) {
            $query = Application::whereHas('getUser', function($query) {
                $query->where('CustNo', auth()->user()->CustNo);
            });
            $statusCounts = Application::getTotalStatusCounts();
        } else {
            $query = Application::where('user_id', auth()->id());
            $statusCounts = Application::getTotalStatusCounts(auth()->id());
        }
        $query = $query->where('claim_number', $request->search)->orderBy('id', 'desc')->get();
        $Applications = $query;
        return view('dashboard.pages.application.index', compact('Applications', 'statusCounts', 'tip', 'basvuru_turu', 'Types'));
    }

    public function quantity_check(Request $request)
    {

        Log::info('Quantity check request', $request->all());

        if ($request->productCode == 500) {
            abort(404);
        }


        $Quantity = Quantity::where('ItemNo', $request->productCode)->first();

        if ($Quantity) {
            return response()->json([
                'success' => true,
                'quantity' => $Quantity->unit
            ]);
        } else {
            return response()->json([
                'success' => false,
                'quantity' => 0
            ]);
        }
    }

    public function allApplications()
    {
        return view('dashboard.pages.applications.index');
    }

    public function allApplicationsFilter(Request $request)
    {
        $year = $request->input('year');
        $custNo = $request->input('CustNo');

        $query = Application::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($custNo) {
            $query->whereHas('user', function ($q) use ($custNo) {
                $q->where('CustNo', $custNo);
            });
        }

        $Applications = $query->with('user.customer')->get();

        //group applications by created_at month with month name in Turkish
        $Applications = $Applications->groupBy(function ($application) {
            return $application->created_at->locale('tr')->isoFormat('MMMM');
        });

        //get all closures
        $Closures = Closure::all();

        //in closure data column there is a data like this.
        // {"BL-22CA1A": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}]}
        //or something like this
        // {"BL-22CA1A": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}], "BL-22CA1Z": [{"qty": "1", "code": "06161", "desc": "Hidrolik yağ", "price": 52.80583333333333, "invoice": "FRD2020092100001"}]}
        //and it has year,month columns
        //for exp. find BL-22CA1A inside applications -> claim_number. add month year and uuid form closures to applications

        //loop every closures, create new array. bl-22ca1a should be key of array. value of array is month and year  and uuid of closure.
        $FilteredClosures = [];
        foreach ($Closures as $Closure) {

            foreach ($Closure->data as $key => $value) {
                $FilteredClosures[$key] = [
                    'month' => $Closure->month,
                    'year' => $Closure->year,
                    'uuid' => $Closure->uuid
                ];
            }
        }

        return view('dashboard.pages.applications.index', compact('Applications', 'FilteredClosures'));

    }

    public function update_accepted_cost(Request $request)
    {
        $application = Application::where('claim_number', $request->claim)->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Başvuru bulunamadı');
        }

        $applicationData = $application->application;
        $applicationData['accepted_cost'] = $request->accepted_cost;
        
        $application->application = $applicationData;
        $application->save();

        return redirect()->back()->with('success', 'Onaylanan masraf tutarı güncellendi');
    }

}
