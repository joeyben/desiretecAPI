<?php

namespace Tests\Feature\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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

    /** @test */
    public function login_fails_when_a_required_field_is_not_filled_in()
    {
        $this->visit('/login')
             ->type('', 'email')
             ->type('', 'password')
             ->press('Login')
             ->seePageIs('/login')
             ->see('E-Mail-Adresse muss ausgefüllt sein.')
             ->see('Passwort muss ausgefüllt sein.');
    }

    /** @test */
    public function login_fails_when_password_is_incorrect()
    {
        $this->visit('/login')
            ->type('admin@desiretec.com', 'email')
            ->type('invalidpass', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.');
    }

    /** @test */
    public function login_failure_with_wrong_inputs()
    {
        $this->visit('/login')
            ->type('wrongusername@wrongpassword.com', 'email')
            ->type('wrongpassword', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.');
    }

    /** @test */
    public function users_can_login()
    {
        // Make sure our events are fired
        Event::fake();

        Auth::logout();

        //User Test
        $this->visit('/login')
                    ->type($this->user->email, 'email')
                    ->type('1234', 'password')
                    ->press('Login')
                    ->see($this->user->full_name)
                    ->seePageIs('/');

        $this->assertLoggedIn();

        Auth::logout();

        //Seller Test
        $this->visit('/login')
                    ->type($this->seller->email, 'email')
                    ->type('1234', 'password')
                    ->press('Login')
                    ->see($this->user->full_name)
                    ->seePageIs('/wishlist');

        $this->assertLoggedIn();

        Auth::logout();

        //Executive Test
        $this->visit('/login')
                    ->type($this->executive->email, 'email')
                    ->type('1234', 'password')
                    ->press('Login')
                    ->seePageIs('/admin/dashboard')
                    ->see($this->executive->email)
                    ->see('Dashboard');

        $this->assertLoggedIn();

        Auth::logout();

        //Admin Test
        $this->visit('/login')
                    ->type($this->admin->email, 'email')
                    ->type('1234', 'password')
                    ->press('Login')
                    ->seePageIs('/admin/dashboard')
                    ->see($this->admin->email)
                    ->see('Dashboard');

        $this->assertLoggedIn();

        Event::assertDispatched(UserLoggedIn::class);
    }
}
