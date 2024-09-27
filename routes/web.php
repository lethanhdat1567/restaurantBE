<?php

use Illuminate\Support\Facades\Route;

Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});