<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *      path="/api/forgot-password",
 *      summary="Forgot password",
 *      description="Forgot password request for a restore link",
 *      operationId="authForgotPassword",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *         required=true,
 *         description="Forgot password request for a restore link",
 *         @OA\JsonContent(
 *            required={"email"},
 *            @OA\Property(property="email", type="string", format="email", example="james.j.b@gmail.com"),
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
 *         response=202,
 *         description="Restore password link send successful via email",
 *         @OA\JsonContent(),
 *      ),
 *      @OA\Response(
 *         response="429",
 *         description="Too Many Requests",
 *      ),
 * )
 */
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
