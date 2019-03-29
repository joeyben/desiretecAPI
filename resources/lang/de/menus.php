<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => 'Management Zugänge',

            'roles' => [
                'all'        => 'Alle Rollen',
                'create'     => 'Rolle erstellen',
                'edit'       => 'Rolle bearbeiten',
                'management' => 'Management Rollen',
                'main'       => 'Rollen',
            ],

            'permissions' => [
                'all'        => 'Alle Berechtigungen',
                'create'     => 'Berechtigung erstellen',
                'edit'       => 'Berechtigung bearbeiten',
                'management' => 'Management Berechtigungen',
                'main'       => 'Berechtigungen',
            ],

            'users' => [
                'all'             => 'Alle User',
                'change-password' => 'Passwort ändern',
                'create'          => 'User erstellen',
                'deactivated'     => 'User deaktivieren',
                'deleted'         => 'User löschen',
                'edit'            => 'User bearbeiten',
                'main'            => 'User',
                'view'            => 'User ansehen',
            ],
        ],

        'log-viewer' => [
            'main'      => 'Log Viewer',
            'dashboard' => 'Dashboard',
            'logs'      => 'Logs',
        ],

        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general'   => 'General',
            'system'    => 'System',
        ],

        'pages' => [
            'all'        => 'Alle Seiten',
            'create'     => 'Seite erstellen',
            'edit'       => 'Seite bearbeiten',
            'management' => 'Management Seiten',
            'main'       => 'Seiten',
        ],

        'blogs' => [
            'all'        => 'Alle Blogs',
            'create'     => 'Blog erstellen',
            'edit'       => 'Blog bearbeiten',
            'management' => 'Management Blogs',
            'main'       => 'Blogs',
        ],

        'wishes' => [
            'all'        => 'Alle Wünsche',
            'create'     => 'Wunsch erstellen',
            'edit'       => 'Wunsch bearbeiten',
            'management' => 'Management Wünsche',
            'main'       => 'Wünsche',
        ],

        'groups' => [
            'all'        => 'Alle Gruppen',
            'create'     => 'Gruppe erstellen',
            'edit'       => 'Gruppe bearbeiten',
            'management' => 'Management Gruppen',
            'main'       => 'Gruppen',
        ],

        'distributions' => [
            'all'        => 'Alle Verteilungen',
            'create'     => 'Verteilung erstellen',
            'edit'       => 'Verteilung bearbeiten',
            'management' => 'Management Verteilungen',
            'main'       => 'Verteilungen',
        ],

        'whitelabels' => [
            'all'        => 'Alle Whitelabel',
            'create'     => 'Whitelabel erstellen',
            'edit'       => 'Whitelabel bearbeiten',
            'management' => 'Management Whitelabel',
            'main'       => 'Whitelabel',
        ],

        'blogcategories' => [
            'all'        => 'Alle Blogkategorien',
            'create'     => 'Blogkategorie erstellen',
            'edit'       => 'Blogkategorie bearbeiten',
            'management' => 'Management Blogkategorie',
            'main'       => 'CMS-Seiten',
        ],

        'blogtags' => [
            'all'        => 'Alle Blog-Tags',
            'create'     => 'Blog-Tag erstellen',
            'edit'       => 'Blog-Tag bearbeiten',
            'management' => 'Management Blog-Tags',
            'main'       => 'Blog-Tags',
        ],

        'blog' => [
            'all'        => 'Alle Blogseiten',
            'create'     => 'Blogseite erstellen',
            'edit'       => 'Blogseite bearbeiten',
            'management' => 'Management Blogseiten',
            'main'       => 'Blogseiten',
        ],

        'faqs' => [
            'all'        => 'Alle FAQ-Seiten',
            'create'     => 'FAQ-Seite erstellen',
            'edit'       => 'FAQ-Seite bearbeiten',
            'management' => 'Management FAQ',
            'main'       => 'FAQ-Seiten',
        ],

        'settings' => [
            'all'        => 'Alle Einstellungen',
            'create'     => 'Einstellungen erstellen',
            'edit'       => 'Einstellungen bearbeiten',
            'management' => 'Management Einstellungen',
            'main'       => 'Einstellungen',
        ],

        'menus' => [
            'all'        => 'Alle Menüs',
            'create'     => 'Menü erstellen',
            'edit'       => 'Menü bearbeiten',
            'management' => 'Management Menüs',
            'main'       => 'Menüs',
        ],

        'modules' => [
            'all'        => 'Alle Modulseiten',
            'create'     => 'Modulseite erstellen',
            'management' => 'Management Module',
            'main'       => 'Modulseiten',
        ],
    ],
    'frontend' => [
        'agents' => [
            'all'        => 'Alle Menüs',
            'create'     => 'Agent erstellen',
            'edit'       => 'Menü bearbeiten',
            'management' => 'Management Menüs',
            'main'       => 'Menüs',
        ]
    ],
    'language-picker' => [
        'language' => 'Sprache',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'ar'    => 'Arabisch',
            'da'    => 'Dänisch',
            'de'    => 'Deutsch',
            'el'    => 'Griechisch',
            'en'    => 'Englisch',
            'es'    => 'Spanisch',
            'fr'    => 'Französisch',
            'id'    => 'Indonesisch',
            'it'    => 'Italienisch',
            'nl'    => 'Niederländisch',
            'pt_BR' => 'Portugiesisch',
            'ru'    => 'Russisch',
            'sv'    => 'Schwedisch',
            'th'    => 'Thai',
        ],
    ],

    'list' => [
        'status' => [
            'all'       => 'Alle Reisewünsche',
            'active'    => 'Aktiv',
            'inactive'  => 'Inaktiv',
            'deleted'   => 'Gelöscht',
        ]
    ],
    'wishes'  => 'Wünsche',
    'sellers' => 'Seller',
];
