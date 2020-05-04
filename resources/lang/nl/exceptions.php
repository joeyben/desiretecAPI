<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Exception Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in Exceptions thrown throughout the system.
    | Regardless where it is placed, a button can be listed here so it is easily
    | found in a intuitive way.
    |
    */
    'whitelabel_mismatch' => 'Keine Übereinstimmung der Logindaten mit dem Whitelabel.',
    'backend' => [
        'access' => [
            'roles' => [
                'already_exists'    => 'Diese Rolle existiert bereits. Bitte wählen Sie einen anderen Namen.',
                'cant_delete_admin' => 'Die Administrator Rolle kann nicht gelöscht werden.',
                'create_error'      => 'Es gab ein Problem bei der Erstellung dieser Rolle. Bitte erneut versuchen.',
                'delete_error'      => 'Es gab ein Problem beim Löschen dieser Rolle. Bitte erneut versuchen.',
                'has_users'         => 'Sie können keine mit Benutzern verknüpfte Rolle löschen.',
                'needs_permission'  => 'Sie müssen mindestens 1 Berechtigung für diese Rolle auswählen.',
                'not_found'         => 'Diese Rolle existiert nicht.',
                'update_error'      => 'Es gab ein Problem beim Ändern dieser Rolle. Bitter erneut versuchen.',
            ],

            'permissions' => [
                'already_exists' => 'Diese Berechtigung existiert bereits. Bitte wählen Sie einen anderen Namen.',
                'create_error'   => 'Es gab ein Problem bei der Erstellung dieser Berechtigung. Bitte erneut versuchen.',
                'delete_error'   => 'Es gab ein Problem beim Löschen dieser Berechtigung. Bitte erneut versuchen.',
                'not_found'      => 'Diese Berechtigung existiert nicht.',
                'update_error'   => 'Es gab ein Problem beim Ändern dieser Berechtigung. Bitter erneut versuchen.',
            ],

            'users' => [
                'cant_deactivate_self'    => 'Sie können das nicht mit sich selbst machen.',
                'cant_delete_self'        => 'Sie können sich nicht selbst löschen.',
                'cant_delete_admin'       => 'Sie können keinen Administrator löschen.',
                'cant_delete_own_session' => 'Sie können nicht Ihre eigene Session löschen.',
                'cant_delete_own_session' => 'Sie können nicht Ihre eigene Session löschen.',
                'cant_restore'            => 'Dieser User ist nicht gelöscht und kann nicht wiederhergestellt werden.',
                'create_error'            => 'Es gab ein Problem bei der Erstellung dieses Users. Bitte erneut versuchen.',
                'delete_error'            => 'Es gab ein Problem beim Löschen dieses Users. Bitte erneut versuchen.',
                'delete_first'            => 'Dieser Benutzer muss zunächst gelöscht werden, bevor er dauerhaft gelöscht werden kann.',
                'email_error'             => 'Diese E-Mail-Adresse gehört zu einem anderen User.',
                'mark_error'              => 'Es gab ein Problem beim Ändern dieses Users. Bitter erneut versuchen.',
                'not_found'               => 'Dieser User existiert nicht.',
                'restore_error'           => 'Es gab ein Problem bei der Wiederherstellung des Users. Bitte erneut versuchen.',
                'role_needed_create'      => 'Sie müssen mindestens eine Rolle auswählen.',
                'role_needed'             => 'Sie müssen mindestens eine Rolle auswählen.',
                'session_wrong_driver'    => 'Your session driver must be set to database to use this feature.',
                'session_wrong_driver'    => 'Your session driver must be set to database to use this feature.',
                'change_mismatch'         => 'Das ist nicht Ihr altes Passwort.',
                'update_error'            => 'Es gab ein Problem bei der Änderung dieses Users. Bitte erneut versuchen.',
                'update_password_error'   => 'Es gab ein Problem bei Ändern dieses User Passworts. Bitte erneut versuchen.',
            ],
        ],
        'pages' => [
            'already_exists' => 'That Page already exists. Please choose a different name.',
            'create_error'   => 'There was a problem creating this Page. Please try again.',
            'delete_error'   => 'There was a problem deleting this Page. Please try again.',
            'not_found'      => 'That Page does not exist.',
            'update_error'   => 'There was a problem updating this Page. Please try again.',
        ],

        'blogcategories' => [
            'already_exists' => 'That Blog Category already exists. Please choose a different name.',
            'create_error'   => 'There was a problem creating this Blog Category. Please try again.',
            'delete_error'   => 'There was a problem deleting this Blog Category. Please try again.',
            'not_found'      => 'That Blog Category does not exist.',
            'update_error'   => 'There was a problem updating this Blog Category. Please try again.',
        ],

        'blogtags' => [
            'already_exists' => 'That Blog Tag already exists. Please choose a different name.',
            'create_error'   => 'There was a problem creating this Blog Tag. Please try again.',
            'delete_error'   => 'There was a problem deleting this Blog Tag. Please try again.',
            'not_found'      => 'That Blog Tag does not exist.',
            'update_error'   => 'There was a problem updating this Blog Tag. Please try again.',
        ],

        'settings' => [
            'update_error' => 'Es gab ein Problem beim Ändern dieser Einstellung. Bitte erneut versuchen.',
        ],

        'menus' => [
            'already_exists' => 'That Menu already exists. Please choose a different name.',
            'create_error'   => 'There was a problem creating this Menu. Please try again.',
            'delete_error'   => 'There was a problem deleting this Menu. Please try again.',
            'not_found'      => 'That Menu does not exist.',
            'update_error'   => 'There was a problem updating this Menu. Please try again.',
        ],

        'modules' => [
            'already_exists' => 'That Module already exists. Please choose a different name.',
            'create_error'   => 'There was a problem creating this Module. Please try again.',
            'delete_error'   => 'There was a problem deleting this Module. Please try again.',
            'not_found'      => 'That Module does not exist.',
            'update_error'   => 'There was a problem updating this Module. Please try again.',
        ],
    ],

    'frontend' => [
        'auth' => [
            'confirmation' => [
                'already_confirmed' => 'Ihr Account wurde bereits bestätigt.',
                'confirm'           => 'Bestätigen Sie Ihren Account!',
                'created_confirm'   => 'Ihr Account wurde erfolgreich erstellt. Wir haben Ihnen eine E-Mail zur Bestätigung geschickt.',
                'created_pending'   => 'Ihr Account wurde erfolgreich erstellt und wartet auf Genehmigung. Nach Genehmigung wird eine E-Mail gesendet.',
                'mismatch'          => 'Ihr Bestätigungs-Code stimmt nicht.',
                'not_found'         => 'Ihr Bestätigungs-Code existiert nicht.',
                'resend'            => 'Ihr Account ist nicht bestätigt. Bitte klicken Sie auf den Bestätigungslink in Ihrer E-Mail, oder <a href=' . route('frontend.auth.account.confirm.resend', ':user_id') . '>klicken Sie hier</a> um sich die Bestätigungs E-Mail erneut zusenden zu lassen.',
                'success'           => 'Ihr Account wurde erfolgreich bestätigt!',
                'resent'            => 'Eine neue Bestätigungs E-Mail wurde an Ihre E-Mail-Adresse geschickt.',
            ],

            'deactivated' => 'Ihr Account wurde deaktiviert.',
            'email_taken' => 'Diese E-Mail-Adresse wird bereits verwendet.',

            'password' => [
                'change_mismatch' => 'Dies ist nicht Ihr altes Passwort.',
            ],

            'registration_disabled' => 'Eine Registrierung ist derzeit nicht möglich.',
        ],
    ],
];
