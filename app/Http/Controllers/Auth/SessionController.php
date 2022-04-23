<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *      path="/api-v1/session",
 *      summary="Get current session info",
 *      description="Get current token session and current user info",
 *      operationId="authSession",
 *      tags={"Auth"},
 *      security={
 *           {"bearerAuth":{}}
 *     },
 *      @OA\Response(
 *           response=200,
 *           description="Token is actual",
 *           @OA\JsonContent(
 *              required={"token","expires", "user"},
 *               @OA\Property(property="token", type="string", example="Bearer 1|UPut4upqjBM8vzWwxQVWhMuStHK2ciYMCPMP9Z8z"),
 *               @OA\Property(property="expires", type="string", example="2022-05-23T10:51:53.168Z"),
 *               @OA\Property(property="user", type="object", required={"name", "email", "image"},
 *                   @OA\Property(
 *                      property="name",
 *                      type="string",
 *                      example="Eugene A."
 *                   ),
 *                   @OA\Property(
 *                      property="email",
 *                      type="string",
 *                      example="jax21ukr@gmail.com"
 *                   ),
 *                   @OA\Property(
 *                      property="image",
 *                      type="string",
 *                      example="https://lh3.googleusercontent.com/a-/AOh14GhEpCWuV63jm4lOfaldnv__nA5a20JmCtaUBsSspA=s96-c"
 *                   ),
 *               ),
 *           )
 *      ),
 *      @OA\Response(
 *         response="401",
 *         description="Unauthenticated",
 *     ),
 *      @OA\Response(
 *           response="429",
 *           description="Too Many Requests",
 *      ),
 * )
 */
class SessionController extends Controller
{
    public function __invoke(Request $request)
    {
        return response([
            'token' => $request->server->get('HTTP_AUTHORIZATION'),
            'expires' => $request->user()->currentAccessToken()->expired_at,
            'user' => [
                "name" => $request->user()->name,
                "email" => $request->user()->email,
                "image" => $request->user()->photo,
            ]
        ], Response::HTTP_OK);
    }
}
