<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

/**
 * @OA\Post(
    * path="/api/login",
    * summary="Sign in",
    * description="Login by email, password",
    * operationId="authLogin",
    * tags={"Auth"},
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"email","password"},
    *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
    *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
    *    ),
    * ),
    * @OA\Response(
    *    response=401,
    *    description="Wrong credentials response",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Credentials not match")
    *    )
    * ),
    * @OA\Response(
    *    response=422,
    *    description="Unprocessable Content",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="The email field is required.")
    *    )
    * ),
    *  @OA\Response(
    *      response=200,
    *      description="Successful logged in",
    *      @OA\JsonContent(
    *          @OA\Property(property="token", type="string", example="1|FXCTLI72DhcrOPSuNt8M9BYmtGz91ziNlJECINpW")
    *      )
    * )
 * )
 */
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
