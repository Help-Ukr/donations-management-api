<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_forgot_password_with_not_existed_email()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('user.forgot'), ['email' => 'wrong@gmail.com']);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_forgot_password_with_existed_email()
    {
        $user = $this->createUser();
        $response = $this->postJson(route('user.forgot'), ['email' => $user->email])
                        ->assertOk();
        // dd($response);
        // $response->assertJsonValidationErrors(['email']);
    }
}
