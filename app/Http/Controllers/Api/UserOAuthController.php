<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\UserOAuthResource;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class UserOAuthController extends Controller
{
    public function user(Request $request)
    {
        return new UserOAuthResource($request->user());
    }

    public function revoke(Request $request)
    {
        $token = $request->user()->token();

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($token->id);

        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
    }
}
