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
        'subject'                 => 'Account Details for :username at :company',
        'subject_for_seller'      => 'Ihre Zugangsdaten zu Ihrem desiretec White Label',
        'subject_for_executive'   => 'Ihre Zugangsdaten zum desiretec System',
        'hello'                   => 'Hello, :username',
        'activate'                => 'Login',
        'activated'               => 'Für Sie wurde ein neuer :account Account für das desiretec Reisewunschportal erstellt.',
        'link'                    => 'Mit Klick auf den folgenden Button können Sie sich mit Ihren Benutzerdaten einloggen.',
        'username'                => 'Email address: :email',
        'password'                => 'Password : :password',
        'greeting'                => 'Thank you for your trust in our services',
    ],
    'wish'              => [
        'subject_for_seller'   => 'Es gibt einen neuen TUI Reisewunsch zur Bearbeitung!',
        'subject_for_seller'   => 'Es gibt einen neuen TUI Reisewunsch zur Bearbeitung!',
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
