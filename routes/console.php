<?php

use App\Utils\CommonUtil;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Remove all file in folder logs
Artisan::command('logs:clear', function () {

    exec('rm -f ' . storage_path('logs/*.log'));

    exec('rm -f ' . base_path('*.log'));

    $this->info('Logs have been cleared!');
})->describe('Clear log files');

Artisan::command('blognt:optimize-clear', function () {
    try {
        $this->info('Blognt optimize clear: Clear all cache, view, route, config!');
        CommonUtil::clearOptimizeCache();
    } catch (\Exception $ex) {
        $this->error('Blognt optimize clear: ' . $ex->getMessage());
        echo "Blognt optimize clear:\n" . $ex->getMessage();
    }
})->describe('Clear all cache as cache, view, route, config');

Artisan::command('blognt:optimize', function () {
    try {
        $this->info('Blognt the cached bootstrap files');
        CommonUtil::newCache();
    } catch (\Exception $ex) {
        $this->error('Blognt optimize: ' . $ex->getMessage());
        echo "Blognt optimize:\n" . $ex->getMessage();
    }
})->describe('Blognt the cached bootstrap files');
