<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class ApplicationController extends Controller
{

    public function index($type =null,$tip = null) {

        $Types = Application::TYPES;
        $IntTypes = Application::INT_TYPES;
         $basvuru_turu = 'tumu';

        if (Auth::user()->hasRole('Yönetici')) {
            $query = Application::query();
            $statusCounts = Application::getTotalStatusCounts();
        } else {
            $query = Application::where('user_id', auth()->id());
            $statusCounts = Application::getTotalStatusCounts(auth()->id());
        }

        if ($type !== null) {
            if($type !== 'tumu') {
                $query->where('type', $type);
            }
            $basvuru_turu = $type;
        }

        if ($tip !== null) {
            if($tip !== 'tumu') {
                $query->where('status', $tip);
            }
        }

        $Applications = $query->orderBy('id','desc')->get();



        return view('dashboard.pages.application.index', compact('Applications', 'statusCounts','tip','basvuru_turu','Types','IntTypes'));

    }

    public function show($claim) {

        $Application = Application::where('claim_number', $claim)->first();

        if(!$Application) {

            return redirect()->route('dashboard');

        }

        $Logs = Activity::whereJsonContains('properties->claim', $Application->claim_number)->orderBy('id','desc')->limit(10)->get();

        $Statuses = Application::STATUS;

        $StatusDetail = $Statuses[$Application->status];

        $Message = null;

        $Files = null;

        if($StatusDetail['hasNotes']) {

            $lastActivity = Activity::where('event','application-status-update')->whereJsonContains('properties->claim', $Application->claim_number)->orderBy('id','desc')->first();

            $Message = $lastActivity->properties['message'] ?? null;

            $Files = $lastActivity->properties['files'] ?? null;

        }

        $Labels = Application::LABELS;

        $FileMatches = Application::FILE_MATCHES;

        return view('dashboard.pages.application.show', compact('Application', 'Logs','Statuses','Message','StatusDetail','Files','Labels','FileMatches'));

    }

    public function update_status($status,$claim_number) {

            $Application = Application::where('claim_number', $claim_number)->first();

            if(!$Application) {

                return redirect()->route('dashboard');

            }

            if(!array_key_exists($status, Application::STATUS)) {

                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Durum bulunamadı.']);

            }

            if($Application->status == $status) {

                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Başvuru zaten değiştirmek istediğiniz duruma sahip.']);

            }


            $Application->status = $status;

            if($Application->save()) {

                activity()
                    ->performedOn($Application)
                    ->causedBy(auth()->user())
                    ->withProperties(['claim' => $Application->claim_number])
                    ->event('application-status-update')
                    ->log(auth()->user()->name . ', '.$Application->claim_number.' numaralı başvurunun durumunu '.$Application->getStatusBadge().' olarak güncelledi.');

                Session::flash('success', 'Durum güncellendi.');

                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

            } else {

                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bir hata oluştu.']);

            }
    }

    public function edit($claim) {

            $Application = Application::where('claim_number', $claim)->first();

            if(!$Application) {

                return redirect()->route('dashboard');

            }

            //TODO - Commenti kaldır.
            /*if(!$Application->editable) {

                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bu başvuru durumu düzenlenemez.']);

            }*/

            $Invoice = Invoice::where('InvoiceNo', $Application->invoice)->first();

            $type = Application::TYPES[$Application->type];

            return view($type['view'], compact('Application', 'Invoice', 'type'));
    }

    public function update_status_with_message(Request $request) {


        $Application = Application::where('claim_number', $request->claim_number)->first();

        if(!$Application) {

            return redirect()->route('dashboard');

        }


        if(!array_key_exists($request->new_status, Application::STATUS)) {


            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Durum bulunamadı.']);

        }

        if($Application->status == $request->new_status) {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Başvuru zaten değiştirmek istediğiniz duruma sahip.']);

        }

        $Application->status = $request->new_status;

        $StatusDetail = Application::STATUS[$request->new_status];

        if($StatusDetail['canEdit']) {
            $Application->editable = true;
        } else {
            $Application->editable = false;
        }

        if($Application->save()) {
            $props = [
                'claim' => $Application->claim_number,
                'message' => $request->message,
                'new_status' => $request->new_status
            ];

            if ($request->has('files.support')) {
                //this input may be has more than one file. if its so, it includes , on this string.
                //check if text has , in it, if it is explode it and save it as array
                //if its not, save support value inside array
                $files = explode(',', $request->input('files.support'));
                $props['files'] = $files;

            }

            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties($props)
                ->event('application-status-update')
                ->log(auth()->user()->name . ', '.$Application->claim_number.' numaralı başvurunun durumunu '.$Application->getStatusBadge().' olarak güncelledi.');

            Session::flash('success', 'Durum güncellendi.');

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

        } else {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bir hata oluştu.']);

        }

    }

    public function firstStep($type = null, $invoice = null){

        try {

            $Invoice = Invoice::where('InvoiceNo', $invoice)->firstOrFail();

            $type = Application::TYPES[$type];

            return view($type['view'], compact('Invoice', 'type'));


        } catch (\Exception $e) {

            \Log::error($e->getMessage());

            if(!app()->isProduction()) {

                dd($e->getMessage());

            } else {

                return redirect()->route('dashboard');

            }
        }
    }

    public function store($type,$invoice,Request $request) {



        if(!$request->has('quantities') && $request->has('application') ) {

            return redirect()->back()->withInput($request->all())->withErrors(['Lütfem zorunlu alanları doldurunuz.']);

        } else {

            //check if invoice is exist
            $DBInvoice = Invoice::where('InvoiceNo', $invoice)->first();

            if(!$DBInvoice) {

                return redirect()->back()->withInput($request->all())->withErrors(['Fatura bulunamadı.']);

            }


            /*//TODO - Ürünleri kontrol et.
            $ProductIds = array_keys($request->quantities);

            $Products = Product::whereIn('id', $ProductIds)->get();

            if($Products->count() != count($ProductIds)) {

                return redirect()->back()->withInput($request->all())->withErrors(['Ürün bulunamadı.']);

            }*/


            $Application = new Application();
            $Application->status = 1;
            $Application->type = $type;
            $Application->invoice = $DBInvoice->InvoiceNo;
            $Application->quantities = $request->quantities;
            $Application->application = $request->application;
            $Application->files = $request->docs;
            $Application->version = 1;
            $Application->user_id = auth()->id();
            $Application->claim_number = $Application->generateClaimNumber();

            if($Application->save()) {

                Session::flash('claim_number', $Application->claim_number);

                activity()
                    ->performedOn($Application)
                    ->causedBy(auth()->user())
                    ->withProperties(['claim' => $Application->claim_number])
                    ->event('application-create')
                    ->log(auth()->user()->name . ', '.$Application->claim_number.' numaralı başvuruyu oluşturdu.');


                //TODO - Başvuru listeleme sayfasına yönlendir.
                return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

            } else {

                return redirect()->back()->withInput($request->all())->withErrors(['Bir hata oluştu.']);

            }

        }

    }

    public function update($claim,Request $request) {


        $Application = Application::where('claim_number', $claim)->first();

        if(!$Application) {

            return redirect()->route('dashboard');

        }

        if(!$Application->editable) {

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number])->withErrors(['Bu başvuru düzenlenemez.']);

        }

        $Application->status = 2;
        $Application->quantities = $request->quantities;
        $Application->application = $request->application;
        $Application->files = $request->docs;
        $Application->version = 2;

        if($Application->save()) {

            Session::flash('success', 'Güncellendi.');

            activity()
                ->performedOn($Application)
                ->causedBy(auth()->user())
                ->withProperties(['claim' => $Application->claim_number])
                ->event('application-content-update')
                ->log(auth()->user()->name . ', '.$Application->claim_number.' numaralı başvurunun içeriğini güncelledi.');

            return redirect()->route('dashboard.application.show', ['claim' => $Application->claim_number]);

        } else {

            return redirect()->back()->withInput($request->all())->withErrors(['Bir hata oluştu.']);

        }

    }



    public function applicationBridge(Request $request) {

        if(!array_key_exists($request->application_type, Application::TYPES)) {

            return redirect()->route('dashboard');

        }

        if(!array_key_exists($request->application_type, Application::TYPES)) {

            return redirect()->route('dashboard');

        }

        $type = Application::TYPES[$request->application_type];

        return redirect()->route('dashboard.application.create', ['type' => $type['slug']]);

    }

    public function invoiceIndex($type, $page = 1) {

        if(!array_key_exists($type, Application::TYPES)) {

            return redirect()->route('dashboard');

        }

        $type = Application::TYPES[$type];

        //TODO CustNo parametresi dinamik olacak
        $Invoices = Invoice::where('CustNo', '120.1050')->orderBy('id','desc')->get();

        return view('dashboard.pages.application.invoice-list', compact('Invoices', 'type'));

    }

    public function search(Request $request) {

        $Types = Application::TYPES;
        $IntTypes = Application::INT_TYPES;
         $basvuru_turu = 'tumu';
         $tip = 'tumu';

        if (Auth::user()->hasRole('Yönetici')) {
            $query = Application::query();
            $statusCounts = Application::getTotalStatusCounts();
        } else {
            $query = Application::where('user_id', auth()->id());
            $statusCounts = Application::getTotalStatusCounts(auth()->id());
        }
        $query= $query->where('claim_number', $request->search)->orderBy('id','desc')->get();
        $Applications = $query;
        return view('dashboard.pages.application.index', compact('Applications', 'statusCounts','tip','basvuru_turu','Types','IntTypes'));
    }

}
