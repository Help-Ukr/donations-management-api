<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *      path="/api/logout",
 *      summary="Log out",
 *      description="Logout user current token",
 *      operationId="authLogout",
 *      tags={"Auth"},
 *      security={
 *           {"bearerAuth":{}}
 *     },
 *      @OA\Response(
 *           response=204,
 *           description="User token removed successful",
 *      ),
 *      @OA\Response(
 *           response="429",
 *           description="Too Many Requests",
 *      ),
 * )
 */
class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request->user());
        $request->user()->currentAccessToken()->delete();
        return response('User token removed', Response::HTTP_NO_CONTENT);
    }
}
