<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

/**
 * @OA\Post(
 *      path="/api/login",
 *      summary="Sign in",
 *      description="Login by email, password",
 *      operationId="authLogin",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Pass user credentials",
 *         @OA\JsonContent(
 *            required={"token","name"},
 *            @OA\Property(property="token", type="string", example="ya29.A0ARrdaM-Oj2yWacijuQ5L3dH6tJcIkpjjZ4XRC18J82zAZjmOCHsYh9ExipfVLXt-p4iRvjaBTsCPm-Y5RE2F-ztkqec08juCUktRdRl6D9dWg9CB7kJl8GrhvGMZaIOICZdNJwtHjoXSW6IivTSF5AW53TT3"),
 *            @OA\Property(property="name", type="string", example="google"),
 *         ),
 *      ),
 *      @OA\Response(
 *           response=401,
 *           description="Wrong credentials response",
 *           @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Credentials not match")
 *           )
 *      ),
 *      @OA\Response(
 *           response=422,
 *           description="Unprocessable Content",
 *           @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="The email field is required.")
 *           )
 *      ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful logged in",
 *           @OA\JsonContent(
 *               @OA\Property(property="token", type="string", example="1|FXCTLI72DhcrOPSuNt8M9BYmtGz91ziNlJECINpW")
 *           )
 *      ),
 *      @OA\Response(
 *           response="429",
 *           description="Too Many Requests",
 *      ),
 * )
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        try {
            $mediaUser = Socialite::driver('google')->userFromToken($request->token);

            $user = User::updateOrCreate(
                ['email' => $mediaUser->email],
                ['name' => $mediaUser->name, 'password' =>  encrypt('123456dummy')]
            );

            return response([
                'token' => $user->createToken('api')->plainTextToken,
            ]);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
