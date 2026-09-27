<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Simplicity is the soul of efficiency.');
})->purpose('Display an inspiring quote');
