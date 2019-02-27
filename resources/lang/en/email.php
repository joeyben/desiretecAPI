<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'account'              => [
        'subject'   => 'Account Details for :username at :company',
        'hello'     => 'Hello, :username',
        'activate'  => 'Activate Your Account',
        'activated' => 'Your Account has been activated. You can login now, please using the following email and password.',
        'link'      => 'Mit Klick auf den folgenden Button können Sie sich mit Ihren Benutzerdaten einloggen.',
        'username'  => 'Email address: :email',
        'password'  => 'Password : :password',
        'greeting'  => 'Thank you for your trust in our services',
    ],

    'footer'              => [
        'line1'     => 'Your Team from ' . config('app.name', 'Theme4Dev'),
        'line2'     => 'TUI GROUP',
        'line3'     => 'Tui Deutschland GmbH',
        'line4'     => 'Auf dem Sande 1 | D-22529 Hamburg | Germany',
        'line5'     => 'Geschäftsführung: John Muster',
        'line6'     => 'Sitz der Gesellschaft: Hamburg',
        'line7'     => 'Handelsregister: Amtsgericht Hamburg HRB XXXXX',
        'line8'     => 'BAN: DEXX XXXX XXXX XXXX XXXX XX',
        'line9'     => 'BIC: XXXXXXXXXX',
    ]
];
