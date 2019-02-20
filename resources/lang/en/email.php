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
        'created'   => 'Your account has been created and an activation link has been sent to the email address you entered. Note that you must activate the account by selecting the activation link when you get the email before you can login.',
        'subject'   => 'Account Details for :username at :company',
        'hello'     => 'Dear, :username',
        'welcome'   => 'Thank you for registering at ' . config('app.name', 'Laravel') . '. Your account is created and must be activated before you can use it. To activate the account click the following button:',
        'activate'  => 'Activate Your Account',
        'activated' => 'Your Account has been activated. You can login now, please using the following email and password.',
        'failed'    => 'Verification code not found, Please log in if you already have an account.',
        'info'      => 'After activation you may login to :url using the following email and the password you entered during registration:',
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
