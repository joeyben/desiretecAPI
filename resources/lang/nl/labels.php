<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'Alle',
        'yes'     => 'Ja',
        'no'      => 'Nein',
        'custom'  => 'Custom',
        'actions' => 'Actionen',
        'active'  => 'Aktiv',
        'buttons' => [
            'save'   => 'Speichern',
            'update' => 'Aktualisieren',
        ],
        'hide'              => 'Verstecken',
        'inactive'          => 'Inaktiv',
        'none'              => 'Keine',
        'show'              => 'Anzeigen',
        'toggle_navigation' => 'Navigation einblenden',
    ],

    'backend' => [
        'profile_updated' => 'Dein Profil wurde aktualisiert.',
        'access'          => [
            'roles' => [
                'create'     => 'Rolle erstellen',
                'edit'       => 'Rolle bearbeiten',
                'management' => 'Management Rollen',

                'table' => [
                    'number_of_users' => 'Useranzahl',
                    'permissions'     => 'Berechtigungen',
                    'role'            => 'Rolle',
                    'sort'            => 'Sorte',
                    'total'           => 'Rollen gesamt',
                ],
            ],

            'permissions' => [
                'create'     => 'Berechtigung erstellen',
                'edit'       => 'Berechtigung bearbeiten',
                'management' => 'Management Berechtigungen',

                'table' => [
                    'permission'   => 'Berechtigung',
                    'display_name' => 'Anzeigename',
                    'sort'         => 'Sorte',
                    'status'       => 'Status',
                    'total'        => 'Rollen gesamt',
                ],
            ],

            'users' => [
                'active'              => 'Aktive User',
                'all_permissions'     => 'Password ändern',
                'change_password_for' => 'Passwort ändern für :user',
                'create'              => 'User erstellen',
                'deactivated'         => 'Deaktivierte User',
                'deleted'             => 'Gelöschte User',
                'edit'                => 'User bearbeiten',
                'edit-profile'        => 'Profil bearbeiten',
                'management'          => 'Management User',
                'no_permissions'      => 'Keine Berechtigungen',
                'no_roles'            => 'Keine Rolle zum Vergeben.',
                'permissions'         => 'Berechtigungen',

                'table' => [
                    'confirmed'      => 'Bestätigt',
                    'created'        => 'Erstellt',
                    'email'          => 'E-Mail-Adresse',
                    'id'             => 'ID',
                    'last_updated'   => 'Vorname',
                    'last_name'      => 'Nachname',
                    'no_deactivated' => 'Keine deaktivieren User',
                    'no_deleted'     => 'Keine gelöschten User',
                    'roles'          => 'Rollen',
                    'total'          => 'User gesamt',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Übersicht',
                        'history'  => 'Historie',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Bestätigt',
                            'created_at'   => 'Erstellt am',
                            'deleted_at'   => 'Gelöscht am',
                            'email'        => 'E-Mail-Adresse',
                            'last_updated' => 'Zuletzt aktualisiert',
                            'name'         => 'Name',
                            'status'       => 'Status',
                            'whitelabels'  => 'Whitelabel',
                        ],
                    ],
                ],

                'view' => 'User ansehen',
            ],
        ],

        'pages' => [
            'create'     => 'Seite erstellen',
            'edit'       => 'Seite erstellen',
            'management' => 'Management Seiten',
            'title'      => 'Seiten',

            'table' => [
                'title'     => 'Titel',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'updatedat' => 'Aktualisiert am',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],

        'blogcategories' => [
            'create'     => 'Blogkategorie erstellen',
            'edit'       => 'Blogkategorie bearbeiten',
            'management' => 'Management Blogkategorie',
            'title'      => 'Blogkategorie',

            'table' => [
                'title'     => 'Blogkategorie',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],

        'blogtags' => [
            'create'     => 'Blog-Tag erstellen',
            'edit'       => 'Blog-Tag bearbeiten',
            'management' => 'Management Blog-Tag',
            'title'      => 'Blog-Tags',

            'table' => [
                'title'     => 'Blog-Tag',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],

        'blogs' => [
            'create'     => 'Blog erstellen',
            'edit'       => 'Blog bearbeiten',
            'management' => 'Management Blogs',
            'title'      => 'Blogs',

            'table' => [
                'title'     => 'Blog',
                'publish'   => 'Veröffentlichungsdatum',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],

        'wishes' => [
            'create'         => 'Wunsch erstellen',
            'edit'           => 'Wunsch bearbeiten',
            'management'     => 'Wünsche',
            'title'          => 'Wünsche',
            'no_whitelabels' => 'keine Whitelabel',
            'table'          => [
                'title'             => 'Wunsch',
                'status'            => 'Status',
                'destination'       => 'Destination',
                'airport'           => 'Flughafen',
                'earliest_start'    => 'Frühester Start',
                'latest_return'     => 'Späteste Rückkehr',
                'createdat'         => 'Erstellt am',
                'createdby'         => 'Erstellt von',
                'whitelabel'        => 'Whitelabel',
                'group'             => 'Gruppe',
                'offerCount'        => 'Angebote',
                'all'               => 'Alle',
            ],
        ],

        'groups' => [
            'create'         => 'Gruppe erstellen',
            'edit'           => 'Gruppe bearbeiten',
            'management'     => 'Gruppen',
            'title'          => 'Gruppen',
            'no_whitelabels' => 'keine Whitelabel',
            'table'          => [
                'name'              => 'Gruppe',
                'display_name'      => 'Anzeigename',
                'status'            => 'Status',
                'users'             => 'User',
                'description'       => 'Beschreibung',
                'createdat'         => 'Erstellt am',
                'createdby'         => 'Erstellt von',
                'whitelabel'        => 'Whitelabel',
                'all'               => 'Alle',
            ],
        ],

        'distributions' => [
            'create'           => 'Verteilung erstellen',
            'edit'             => 'Verteilung bearbeiten',
            'management'       => 'Verteilungen',
            'title'            => 'Verteilungen',
            'no_distributions' => 'keine Verteilungen',
            'table'            => [
                'name'              => 'Verteilung',
                'display_name'      => 'Anzeigename',
                'description'       => 'Beschreibung',
                'createdat'         => 'Erstellt am',
                'createdby'         => 'Erstellt von',
                'whitelabel'        => 'Whitelabel',
                'all'               => 'Alle',
            ],
        ],

        'whitelabels' => [
            'create'            => 'Whitelabel erstellen',
            'edit'              => 'Whitelabel bearbeiten',
            'management'        => 'Whitelabel',
            'management_client' => 'Whitelabel',
            'title'             => 'Whitelabel',

            'table' => [
                'name'           => 'Key',
                'display_name'   => 'Whitelabel',
                'distribution'   => 'Verteilung',
                'status'         => 'Status',
                'createdat'      => 'Erstellt am',
                'createdby'      => 'Erstellt von',
                'all'            => 'Alle',
                'ga_view_id'     => 'Google View Id',
            ],
        ],

        'emailtemplates' => [
            'create'     => 'E-Mail-Template erstellen',
            'edit'       => 'E-Mail-Template bearbeiten',
            'management' => 'Management E-Mail-Templates',
            'title'      => 'E-Mail-Templates',

            'table' => [
                'title'     => 'Titel',
                'subject'   => 'Betreff',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'updatedat' => 'Aktualisiert am',
                'all'       => 'Alle',
            ],
        ],

        'settings' => [
            'edit'           => 'Einstellungen bearbeiten',
            'management'     => 'Management Einstellungen',
            'title'          => 'Einstellungen',
            'seo'            => 'SEO-Einstellungen',
            'companydetails' => 'Unternehmenskontaktdaten',
            'mail'           => 'E-Mail-Einstellungen',
            'footer'         => 'Footer-Einstellungen',
            'terms'          => 'Geschäftsbedingungen-Einstellungen',
            'google'         => 'Google Analytics Tracking Code',
        ],

        'faqs' => [
            'create'     => 'FAQ erstellen',
            'edit'       => 'FAQ bearbeiten',
            'management' => 'Management FAQ ',
            'title'      => 'FAQ',

            'table' => [
                'title'     => 'FAQs',
                'publish'   => 'Veröffentlichungsdatum',
                'status'    => 'Status',
                'createdat' => 'Erstellt am',
                'createdby' => 'Erstellt von',
                'answer'    => 'Antwort',
                'question'  => 'Frage',
                'updatedat' => 'Aktualisiert am',
                'all'       => 'Alle',
            ],
        ],

        'menus' => [
            'create'     => 'Menü erstellen',
            'edit'       => 'Menü bearbeiten',
            'management' => 'Management Menü',
            'title'      => 'Menüs',

            'table' => [
                'name'      => 'Name',
                'type'      => 'Typ',
                'createdat' => 'Erstellt am',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
            'field' => [
                'name'      => 'Name',
                'type'      => 'Typ',
                'items'     => 'Menüfelder',
                'url'       => 'URL',
                'url_type'  => 'URL-Typ',
                'url_types' => [
                  'route'  => 'Route',
                  'static' => 'Statisch',
                ],
                'open_in_new_tab'    => 'Öffne URL in neuem Tab',
                'view_permission_id' => 'Berechtigung',
                'icon'               => 'Icon-Klasse',
                'icon_title'         => 'Font Awesome Class. eg. fa-edit',
            ],
        ],

        'modules' => [
            'create'     => 'Modul erstellen',
            'management' => 'Management Module',
            'title'      => 'Module',
            'edit'       => 'Module bearbeiten',

            'table' => [
                'name'               => 'Modulname',
                'url'                => 'Modul Pfad anzeigen',
                'view_permission_id' => 'Berechtigung sehen',
                'created_by'         => 'Erstellt von',
            ],

            'form' => [
                'name'                  => 'Modulname',
                'url'                   => 'Pfad',
                'view_permission_id'    => 'Berechtigung ansehen',
                'directory_name'        => 'Directory Name',
                'namespace'             => 'Namespace',
                'model_name'            => 'Model Name',
                'controller_name'       => 'Controller &nbsp;Name',
                'resource_controller'   => 'Resourceful Controller',
                'table_controller_name' => 'Controller &nbsp;Name',
                'table_name'            => 'Tabellen Name',
                'route_name'            => 'Pfadname',
                'route_controller_name' => 'Controller &nbsp;Name',
                'resource_route'        => 'Resourceful Routes',
                'views_directory'       => 'Directory &nbsp;&nbsp;&nbsp;Name',
                'index_file'            => 'Index',
                'create_file'           => 'Erstellen',
                'edit_file'             => 'Bearbeiten',
                'form_file'             => 'Form',
                'repo_name'             => 'Repository Name',
                'event'                 => 'Event Name',
            ],
        ],
    ],

    'frontend' => [
        'auth' => [
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login mit :social_media',
            'register_box_title' => 'Registrieren',
            'register_button'    => 'Registrieren',
            'remember_me'        => 'Erinnere mich',
        ],

        'passwords' => [
            'forgot_password'                 => 'Passwort vergessen?',
            'reset_password_box_title'        => 'Passwort zurücksetzen',
            'reset_password_button'           => 'Passwort zurücksetzen',
            'send_password_reset_link_button' => 'Sende Passwort-Reset-Link',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Makrobeispiele',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => 'Zeitzone',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Passwort ändern',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Erstellt am',
                'edit_information'   => 'Informationen bearbeiten',
                'email'              => 'E-Mail-Adresse',
                'last_updated'       => 'Zuletzt geändert',
                'first_name'         => 'Vorname',
                'last_name'          => 'Nachname',
                'address'            => 'Adresse',
                'country'            => 'Land',
                'city'               => 'Stadt',
                'zipcode'            => 'PLZ',
                'ssn'                => 'SSN',
                'update_information' => 'Profil ändern',
            ],
        ],

        'offers' => [
            'create'          => 'Neues Angebot erstellen',
            'management'      => 'Angebote',
            'offers_for_wish' => 'Angebote für',
            'table'           => [
                'title'     => 'Angebot',
                'status'    => 'Status',
                'createdat' => 'Erstellt in',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],

        'agents' => [
            'create'     => 'Neuen Agenten erstellen',
            'management' => 'Agenten',
            'table'      => [
                'avatar'           => 'Avatar',
                'name'             => 'Name',
                'display_name'     => 'Anzeigename',
                'status'           => 'Status',
                'created_at'       => 'Erstellt am',
                'createdby'        => 'Erstellt von',
                'id'               => 'ID',
            ],
        ],
        'wishes' => [
            'wishes'        => 'Reisewünsche',
            'goto'          => 'Reisewunsch ansehen',
            'created_at'    => 'erstellt am',
            'edit'          => 'Reisewunsch bearbeiten',
            'add-comment'   => 'Kommentar hinzufügen',
            'week'          => ':value Woche|:value Wochen',
            'night'         => ':value Nacht|:value Nächte',
            'table'         => [
                'adults' => ':count Erwachsener|:count Erwachsene',
                'kids'   => '{0}Kein Kinder|Kind|Kinder',
            ]
        ],
        'dashboard' => [
            'analytics' => [
                'created_wishes'         => 'Erstellte Reisewünsche',
                'changed_wishes'         => 'Bearbeitete Reisewünsche',
                'free_text'              => 'Freitext',
                'answered_wishes'        => 'Beantwortete Reisewünsche',
                'reaction_quota'         => 'Reaktionsquote',
                'latest_answered_wishes' => 'Zuletzt beantwortete Reisewünsche',
                'latest_reaction_quota'  => 'Aktuelle Reaktionsquote',
                'bookings'               => 'Buchungen',
                'reaction_time'          => 'Reaktionszeit'
            ]
        ]
    ],
    'wish'                     => 'Reisewunsch',
    'wishes'                   => 'Reisewünsche',
    'id'                       => 'ID',
    'name'                     => 'Name',
    'title'                    => 'Titel',
    'username'                 => 'Username',
    'first_name'               => 'Vorname',
    'last_name'                => 'Nachname',
    'full_name'                => 'Name',
    'email'                    => 'E-Mail',
    'country'                  => 'Land',
    'password_confirm'         => 'Passwort bestätigen',
    'current_password'         => 'Aktuelles Passwort',
    'language'                 => 'Sprache',
    'about'                    => 'Über uns',
    'interest'                 => 'Internet',
    'personal_timezone'        => 'Zeitzone',
    'occupation'               => 'Beruf',
    'activated'                => 'aktiviert',
    'tel'                      => 'Telefonnummer',
    'fax'                      => 'Fax',
    'street'                   => 'Straße',
    'zipcode'                  => 'PLZ',
    'ok'                       => 'Ok',
    'cancel'                   => 'Abbrechen',
    'warning'                  => 'Warnung',
    'online'                   => 'Online',
    'user'                     => 'User',
    'documents'                => 'Dokumente',
    'login'                    => 'Login',
    'logout'                   => 'Logout',
    'register'                 => 'Registrieren',
    'join'                     => 'Beitreten',
    'now'                      => 'Jetzt',
    'plus'                     => 'plus',
    'new'                      => 'Neu',
    'posts'                    => 'Posts',
    'events'                   => 'Events',
    'feedback'                 => 'Feedback',
    'name'                     => 'Name',
    'email'                    => 'E-Mail-Adresse',
    'subject'                  => 'Betreff',
    'recipient'                => 'Empfänger',
    'message'                  => 'Nachricht',
    'password'                 => 'Passwort',
    'send'                     => 'Jetzt senden',
    'verify'                   => 'E-Mail-Verifizierung',
    'verify_email'             => 'Verifiziere Deine E-Mail-Adresse',
    'reset'                    => 'Passwort zurücksetzen',
    'reset_link'               => 'Passwort-Reset-Link senden',
    'contact'                  => 'Kontakt',
    'mobile'                   => 'Mobile',
    'phone'                    => 'Telefon',
    'message_text'             => 'Nachrichtentext',
    'notes'                    => 'Notizen',
    'address'                  => 'Adresse',
    'note'                     => 'Notiz',
    'notes'                    => 'Notizen',
    'account'                  => 'Account',
    'download'                 => 'Download',
    'details'                  => 'Details',
    'attendee'                 => 'Teilnehmer',
    'attendees'                => 'Teilnehmer',
    'description'              => 'Beschreibung',
    'content'                  => 'Inhalt',
    'review'                   => 'Rezension',
    'ratings'                  => 'Bewertungen',
    'current'                  => 'Aktuell',
    'logo'                     => 'Logo',
    'domain'                   => 'Domain',
    'whitelabel_information'   => 'Whitelabel Informationen',
    'whitelabel_executive'     => 'Whitelabel Executive',
    'go_next'                  => 'Weiter!',
    'go_back'                  => 'Zurück!',
    'finish'                   => 'Fertig',
    'whitelabel_title'         => 'Neues Whitelabel',
    'whitelabel_subtitle'      => 'Ein neuer Untertitel',
    'notifications'            => 'Benachrichtigungen',
    'inbox'                    => 'Posteingang',
    'whitelabel'               => 'Whitelabel',
    'role'                     => 'Rolle',
    'export_selected'          => 'Auswahl exportieren',
    'export_all'               => 'Alles exportieren',
    'footers'                  => 'Footers',
];
