<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_test_logout()
    {
        $this->authUser();
        $this->getJson(route('item-category.index'))->assertOk();
        $this->getJson(route('user.logout'))->assertNoContent();

        $this->withExceptionHandling();
        $this->app->get('auth')->forgetGuards();
        $json = $this->getJson(route('item-category.index'))->assertUnauthorized();
    }
}
