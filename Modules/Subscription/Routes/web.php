<?php

\Illuminate\Support\Facades\Route::get('test', function(){
    \Modules\Expert\Jobs\SyncTopExpertJob::dispatch();
});
