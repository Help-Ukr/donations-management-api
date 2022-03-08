<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink( $request->only('email') );

        if($status != Password::RESET_LINK_SENT) {
            return response(['status' => __($status)], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        return response(Response::HTTP_ACCEPTED);
    }
}
