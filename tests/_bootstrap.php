<?php
// This is global bootstrap for autoloading
use Illuminate\Support\Facades\Artisan;

require __DIR__.'/../bootstrap/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';

// setup env
$currentEnv = array_filter($_SERVER['argv'], function ($arg) {
    if (strrpos($arg, '--env=') !== false) {
        return true;
    }
});
$env = 'testing';
if (!empty($currentEnv)) {
    $env = str_replace('--env=', '', current($currentEnv));
} else {
    $app->loadEnvironmentFrom('.env.' . $env);
}

$app->instance('request', new \Illuminate\Http\Request);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

Artisan::call('db:wipe');
Artisan::call('migrate');
Artisan::call('db:seed');
Artisan::call('config:clear');
Artisan::call('cache:clear');
Artisan::call('route:clear');
