<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private $userData;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->userData = User::factory()->make()->toArray();
        $this->userData['password'] = 'password';
        $this->userData['password_confirmation'] = 'password';
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_register()
    {
        $this->postJson(route('user.register'), $this->userData);

        $this->assertDatabaseHas('users', ['name' => $this->userData['name']]);
    }

    public function test_a_user_can_register_with_the_same_email()
    {
        $this->postJson(route('user.register'), $this->userData)->assertCreated();
        $this->assertDatabaseHas('users', ['name' => $this->userData['name']]);

        $this->withExceptionHandling();
        $response = $this->postJson(route('user.register'), $this->userData)->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }
}
