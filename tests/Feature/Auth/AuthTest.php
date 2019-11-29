<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Tests\BrowserKitTestCase;

class AuthTest extends BrowserKitTestCase
{
    /** @test */
    public function login_token_page_loads_properly()
    {
        Auth::logout();
        $this->assertLoggedOut();

        $this->visit('/login/token')
            ->see(Lang::get('label.tokenlogin.email'))
            ->see(Lang::get('button.tokenlogin.send'));
    }

    /** @test */
    public function login_fails_when_a_required_field_is_incorrect()
    {
        $this->visit('/login/token')
             ->type('invalidpass@desiretec.com', 'email')
             ->press(Lang::get('button.tokenlogin.send'))
             ->seePageIs('/login/token')
             ->see(Lang::get('validation.exists', ['attribute' => Lang::get('validation.attributes.email')]));
    }

    /** @test */
    public function users_can_login_token()
    {
        Event::fake();

        Auth::logout();

        $this->visit('/login/token')
                    ->type($this->user->email, 'email')
                    ->press(Lang::get('button.tokenlogin.send'))
                    ->seePageIs('/login/token')
                    ->see(Lang::get('messages.token_send'));

        $this->assertLoggedOut();

        $this->visit('/login/token/' . $this->user->token->token . '?' . http_build_query(['email' => trim($this->user->email)]))
                    ->seePageIs('/');

        $this->assertLoggedIn();
    }
}
