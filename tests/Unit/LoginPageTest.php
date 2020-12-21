<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function login_page_returns_status_200()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function register_page_returns_404()
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
}
