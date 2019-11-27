<?php

namespace Tests\Feature\Auth;

use Tests\BrowserKitTestCase;

class LoginTest extends BrowserKitTestCase
{
    /** @test */
    public function login_page_loads_properly()
    {
        $this->visit('/login')
            ->see('Email')
            ->see('Password')
            ->see('Login')
            ->dontSee('You are logged in!');
    }
}
