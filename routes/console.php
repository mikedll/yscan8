<?php

use Illuminate\Foundation\Inspiring;

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
})->describe('Display an inspiring quote');

Artisan::command('redoscores', function () {
    $videos = App\Video::all();
    foreach($videos as $v) {
        $v->calculateScore();
        $v->save();
        $this->comment("Recalculated " . $v->id);
    }
    $this->comment("Done.");
})->describe('Recalculate all video scores, if the score equation has changed.');
