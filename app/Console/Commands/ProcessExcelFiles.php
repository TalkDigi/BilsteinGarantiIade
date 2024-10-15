<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ProcessExcelFiles extends Command
{
    protected $signature = 'excel:process';
    protected $description = 'Process waiting Excel files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        Log::info('ProcessExcelFiles command started');
        $waitingPath = public_path('processes/waiting-jobs');
        $runningPath = public_path('processes/running-jobs');

        $files = array_diff(scandir($waitingPath), ['..', '.']);
        Log::info('Files found: '.print_r($files,true));

        $files = array_values($files);

        if (count($files) > 0) {
            $file = $files[0];

            rename("$waitingPath/$file", "$runningPath/$file");

            // Dispatch the job to process the file
            \App\Jobs\ProcessExcelFile::dispatch($file);
        }
    }
}
