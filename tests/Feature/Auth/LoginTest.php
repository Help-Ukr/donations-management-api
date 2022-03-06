<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->user = User::factory()->create();
        // $this->user['password'] = 'password';
        // $this->user['password_confirmation'] = 'password';
    }
    
    public function test_a_user_can_login_with_email_and_password()
    {
        $response = $this->postJson(route('user.login'), ['email' => $this->user->email, 'password' => 'password'])
        // dd($response);
                       ->assertOk();//

        $this->assertArrayHasKey('token', $response->json());
    }
    
    public function test_if_user_email_is_not_available_then_it_return_error()
    {
        $response = $this->postJson(route('user.login'), ['email' => 'email@gmail.com', 'password' => 'password'])
                        ->assertUnauthorized();
        // dd($response->json());
        //                ->assertOk();//

        // $this->assertArrayHasKey('token', $response->json());
    }

    public function test_if_user_password_is_incorrect_then_it_return_error()
    {
        $response = $this->postJson(route('user.login'), ['email' => $this->user->email, 'password' => 'wrong password'])
                        ->assertUnauthorized();
    }
}
