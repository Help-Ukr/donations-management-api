<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *      path="/api/register",
 *      summary="Register",
 *      description="Register user by name, email, password",
 *      operationId="authRegister",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Register user details",
 *         @OA\JsonContent(
 *            required={"name", "email","password"},
 *            @OA\Property(property="name", type="string", format="string", example="James Joseph Brown"),
 *            @OA\Property(property="email", type="string", format="email", example="james.j.b@gmail.com"),
 *            @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *            @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
 *         ),
 *      ),
 *      @OA\Response(
 *         response=422,
 *         description="Unprocessable Content",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="The email field is required.")
 *         )
 *      ),
 *       @OA\Response(
 *           response=201,
 *           description="Successful user registered",
 *           @OA\JsonContent(
 *              @OA\Property(property="token", type="string", example="4|YgqDFR0oCsABfkMES8e65OTVBacZ5fHNnsPFRTMc"),
 *           )
 *      ),
 *      @OA\Response(
 *           response="429",
 *           description="Too Many Requests",
 *      ),
 * )
 */
class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response([
                            'token' => $user->createToken('api')->plainTextToken,
                        ], Response::HTTP_CREATED);
    }
}
