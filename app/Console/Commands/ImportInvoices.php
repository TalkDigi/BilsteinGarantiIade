<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class ImportInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kullanıcıya ait faturaları getirir.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $json = file_get_contents(public_path('invoices.json'));

        $invoices = json_decode($json, true);

        $chunks = array_chunk($invoices, 1000);

        foreach ($chunks as $chunk) {

            foreach ($chunk[0] as $invoiceData) {

                Invoice::create([
                    'InvoiceNo' => $invoiceData['InvoiceNo'],
                    'CustNo' => $invoiceData['CustNo'],
                    'Branch' => $invoiceData['Branch'],
                    'BranchID' => $invoiceData['BranchID'],
                    'PostingDate' => $invoiceData['PostingDate'],
                    'ExDocNo' => $invoiceData['ExDocNo'],
                    'Amt' => $invoiceData['Amt'],
                    'AmtIncVAT' => $invoiceData['AmtIncVAT'],
                    'Line' => $invoiceData['Line'],
                ]);

            }

        }

    }

}
