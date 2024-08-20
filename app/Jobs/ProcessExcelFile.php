<?php

namespace App\Jobs;

use App\Imports\QuantityImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImportClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
class ProcessExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle()
    {

        Log::info('Job dispatch edildi.');

        $runningPath = public_path('processes/running-jobs');
        $completedPath = public_path('processes/completed-jobs');

        $filePath = "$runningPath/{$this->fileName}";

        // Import the file
        Excel::import(new QuantityImport($filePath), $filePath);

        // Move the file to completed-jobs
        rename($filePath, "$completedPath/{$this->fileName}");
    }
}
