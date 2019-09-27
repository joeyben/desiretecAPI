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

    'account' => [
        'subject'                 => 'Account Details for :username at :company',
        'subject_for_seller'      => 'Ihre Zugangsdaten zum :whitelabel Reisewunschportal',
        'subject_for_executive'   => 'Ihre Zugangsdaten zu Ihrem :whitelabel Reisewunschportal',
        'hello'                   => 'Hallo :username',
        'activate'                => 'Login',
        'activated'               => 'Für Sie wurde ein neuer :account Account für das :whitelabel Reisewunschportal erstellt.',
        'link'                    => 'Mit Klick auf den folgenden Button können Sie sich mit Ihren Benutzerdaten einloggen.',
        'username'                => 'E-Mail-Adresse: :email',
        'password'                => 'Passwort: :password',
        'greeting'                => 'Thank you for your trust in our services',
    ],
    'wish'    => [
        'subject_for_seller'        => 'Es gibt einen neuen :whitelabel Reisewunsch zur Bearbeitung!',
        'user_cnt_seller'           => 'Ihr Angebot war erfolgreich, Sie haben einen neuen Kontakt erzeugt!',
        'user_callback_seller'      => 'Ihr Kunde bittet Sie um einen Rückruf',
        'user'                      => 'Herzlich willkommen beim :whitelabel Reisewunschportal! Ihr Reisewunsch wurde erfolgreich erstellt.',
        'seller'                    => 'Es gibt einen neuen :whitelabel Reisewunsch zur Bearbeitung!',
        'user_novasol'              => 'Herzlich willkommen beim NOVASOL Reisewunschportal! Ihr Reisewunsch wurde erfolgreich erstellt.',
    ],
    'offer'   => [
        'created'        => 'Sie haben erfolgreich ein Angebot erstellt',
        'created_user'   => 'Es gibt ein neues Angebot für Ihren :whitelabel Reisewunsch!',
        'header'         => 'Hallo!',
        'body'           => "<p>Hallo! </p>
                            <p>Herzlich willkommen bei Ihrem :whitelabel Reisewunschportal. </p>
                            <p>Sie haben sich soeben registriert und Ihr Reisewunsch <a href=':link'>:link</a> wurde erfolgreich an uns übermittelt.</p>
                            <p>Wir suchen gerade nach passenden Angeboten für Ihren persönlichen Reisewunsch und informieren Sie in wenigen Minuten per E-Mail darüber.</p>
                            <p>Anschließend können Sie sich Ihre persönlichen Angebote im :whitelabel Reisewunschportal anschauen.</p>",
        'link'           => "Sie können diese unter dem folgenden Link direkt aufrufen <a href=':link'>:link</a>",
        'footer'         => 'Wir hoffen, dass Ihnen die Angebote zusagen. Bei Fragen stehen Ihnen unsere Reiseberater jederzeit zur Verfügung.',
        'novasol_created_user'      => [
            'subject'=> 'Wir haben Ihre Traumferien gefunden – NOVASOL Reisewunschportal',
            'header' => 'Hallo lieber Kunde!',
            'body'   => 'Herzlichen Glückwunsch! Wir haben neue passende :whitelabel Angebote für Ihren Reisewunsch gefunden.',
            'link'   => 'Sie können diese unter dem folgenden Link direkt aufrufen <a href=":link">:link</a>',
            'footer' => 'Wir hoffen, dass Ihnen die Angebote zusagen. Bei Fragen stehen Ihnen unsere Reiseberater jederzeit zur Verfügung.'
        ]
    ],
    'token_new'   => 'Vielen Dank für das Anfordern Ihrer Zugangsdaten zum :whitelabel Reisewunschportal. 
                    Sie können sich über den folgenden Link ganz einfach in Ihr Profil einloggen. 
                <a href=":token">:token</a>',
    'message' => [
        'new'            => 'Neue Nachricht!',
        'subject'        => 'Sie haben eine neue Nachricht erhalten',
        'token_new'          => 'Ihr Zugang zu Ihrem :whitelabel Reisewunschportal ',
        'created-seller' => 'Sie haben eine neue Nachricht von Ihrem Kunden erhalten',
        'created-user'   => 'Wichtig: Es gibt eine neue Nachricht von Ihrem Berater im :whitelabel Reisewunschportal',
    ],
    'footer'              => [
        'line1'           => 'Sonnige Grüße',
        'line2'           => 'Ihr desiretec Team',
        'line3'           => 'DesireTec GmbH',
        'line4'           => 'Auf dem Sande 1 | D-20457 Hamburg | Deutschland',
        'line5'           => 'Geschäftsführung: John Muster',
        'line6'           => 'Sitz der Gesellschaft: Hamburg',
        'line7'           => 'Handelsregister: Amtsgericht Hamburg HRB XXXXX',
        'line8'           => 'BAN: DEXX XXXX XXXX XXXX XXXX XX',
        'line9'           => 'BIC: XXXXXXXXXX',
    ],
    'footer_novasol' => [
        'line1'         => 'Mit freundlichen Grüßen | With kind regards | Med venlig hilsen',
        'line2'         => 'Ihr NOVASOL Buchungsservice',
        'line3'         => 'NOVASOL Reise GmbH',
        'line4'         => 'Gotenstrasse 11 - 20097 Hamburg, Germany',
        'line5'         => 'Phone +49 (0) 40 238859 - 82 | novasol@novasol.de – an Awaze Company',
        'line6'         => 'Handelsregister Amtsgericht Hamburg, HRB 95067 | Geschäftsführer: Jan Haapanen',
        'line7'         => 'www.novasol.de | www.dansommer.de | www.cuendet.de',
    ]
];
