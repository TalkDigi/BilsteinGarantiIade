<?php

namespace App\Providers;

use App\Models\Complaint;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\File;
use App\Models\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Carbon::setLocale('tr');

        $setting_db = Setting::all();

        $Complaints = Complaint::where('status','1')->get();
        //make their ids key
        $ProviderComplaints = [];
        foreach($Complaints as $complaint) {
            $ProviderComplaints[$complaint->id] = $complaint;
        }

        $Settings = [];

        foreach($setting_db as $setting) {
            $Settings[$setting->key] = $setting->value;
        }

        $MenuFile = File::where('status',1)->where('show_menu',1)->get();

        $ApplicationStatus = Status::where('status',1)->get();

        $ApplicationStatusById = [];
        foreach($ApplicationStatus as $status) {
            $ApplicationStatusById[$status->id] = $status;
        }

        $ApplicationTypes = Type::all();

        $Customers = \App\Models\Customer::all();

        $NonViewed = Application::whereNull('viewed_by')->get();


        $WaitingForEdit = Application::where('status',4)->get();

        view()->share('Settings', $Settings);

        view()->share('ProviderComplaints', $ProviderComplaints);

        view()->share('MenuFile', $MenuFile);

        view()->share('ApplicationStatus', $ApplicationStatus);

        view()->share('ApplicationTypes', $ApplicationTypes);

        view()->share('ApplicationStatusById', $ApplicationStatusById);

        view()->share('Customers', $Customers);

        view()->share('NonViewed', $NonViewed);

        view()->share('WaitingForEdit', $WaitingForEdit);


    }
}
