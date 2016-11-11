<?php

use Illuminate\Foundation\Inspiring;
use Lufficc\MarkDownParser;

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
});

Artisan::command('parse', function () {
    $parse = new Parsedown();
    foreach (\App\Post::all() as $post)
    {
        $post->html_content = $parse->setBreaksEnabled(true)->text($post->content);
        $this->comment($post->save());
    }
});


Artisan::command('avatar', function () {
    $this->comment(\App\User::whereNull('avatar')->update(['avatar' => config('app.avatar')]));
});

Artisan::command('xssProtection', function () {
    $mp = new MarkDownParser();
    foreach (\App\Comment::withoutGlobalScopes()->get() as $comment) {
        $this->comment("----------------------------------------------------------------------------------------\n");
        $this->comment($comment->content . "\n\n");
        $this->comment($comment->html_content . "\n\n");
        $parsed = $mp->parse($comment->content);
        $this->comment($parsed . "\n\n");
        $comment->html_content = $parsed;
        $this->comment('save:' . $comment->save());
        $this->comment("----------------------------------------------------------------------------------------");
    }

});
