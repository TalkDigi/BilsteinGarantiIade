<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ProcessExcelFiles;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('excel:process', function () {
    $command = new ProcessExcelFiles();
    $command->handle();
})->purpose('Process waiting Excel files')->everyMinute();


