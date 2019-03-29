<?php

return [
    'messages' => [
        'registeration' => [
            'success' => 'Du hast dich erfolgreich registriert. Bitte überprüfe zur Aktivierung deine E-Mails.',
        ],
        'login' => [
            'success' => 'Login erfolgreich.',
            'failed'  => 'Ungültige Zugangsdaten! Bitte erneut versuchen.',
        ],
        'logout' => [
            'success' => 'Erfolgreich ausgeloggt.',
        ],
        'forgot_password' => [
            'success'    => 'Wir haben eine E-Mail mit einem Link zum Zurücksetzen des Passworts geschickt.',
            'validation' => [
                'email_not_found' => 'Diese E-Mail-Adresse ist uns nicht bekannt.',
            ],
        ],
        'refresh' => [
            'token' => [
                'not_provided' => 'Token not provided.',
            ],
            'status' => 'Ok',
        ],
    ],
];
