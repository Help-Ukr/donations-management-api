<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if(!\Auth::attempt($request->validated())) {
            return response('Credentials not match', Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken('api');

        return response([
            'token' => $token->plainTextToken,
        ]);
    }
}
