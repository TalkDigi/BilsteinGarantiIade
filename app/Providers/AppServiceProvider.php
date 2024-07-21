<?php

namespace App\Providers;

use App\Models\Complaint;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\File;

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

        view()->share('Settings', $Settings);
        view()->share('ProviderComplaints', $ProviderComplaints);
        view()->share('MenuFile', $MenuFile);

    }
}
