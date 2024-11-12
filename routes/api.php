<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('oauth/user', [Api\UserOAuthController::class, 'user'])->middleware('scopes:email');
    Route::delete('oauth/revoke', [Api\UserOAuthController::class, 'revoke']);
});
