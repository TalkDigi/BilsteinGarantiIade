<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class CheckCustomerClosures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:customer-closures';
    protected $description = 'Check if customers have Closure records for the current month and send an email if not';


    /**
     * Execute the console command.
     */
    public function handle()
    {

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $Applications = Application::whereBetween('confirmed_at', [$startOfMonth, $endOfMonth])->get();


        $emails = [];
        $customers = [];

        foreach ($Applications as $application) {
            $user = User::where('id', $application->user_id)->first();

            $emails[$user->CustNo] = $user->email;
            $customers[$user->CustNo] = Customer::where('No', $user->CustNo)->first();

        }

        $customers = array_unique($customers);

        Log::info('Customerlar alındı'.print_r($customers,true));

        foreach ($customers as $key => $customer) {

            $closures = Closure::where('CustNo', $key)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();

            Log::info('bU KADAR BAŞVURU'.count($closures));

            if ($closures->count() == 0) {
                Log::info('No closure found for customer: ' . $key);
                try {
                    Mail::to($emails[$key])->send(new \App\Mail\NoClosureMail($customer));
                    Log::info('Mail sent to: ' . $emails[$key]);
                } catch (\Exception $e) {
                    Log::error('Error sending mail to: ' . $emails[$key]);
                }
            }
        }


        die();





        /*Mail::to($customer->email)->send(new \App\Mail\NoClosureMail($customer));*/

        $this->info('Cron job executed successfully.');
    }
}
