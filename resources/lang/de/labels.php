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
        'actions' => 'Actions',
        'active'  => 'Aktiv',
        'buttons' => [
            'save'   => 'Speichern',
            'update' => 'Aktualisieren',
        ],
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
    ],

    'backend' => [
        'profile_updated' => 'Your profile has been updated.',
        'access'          => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'permissions' => [
                'create'     => 'Create Permission',
                'edit'       => 'Edit Permission',
                'management' => 'Permission Management',

                'table' => [
                    'permission'   => 'Permission',
                    'display_name' => 'Display Name',
                    'sort'         => 'Sort',
                    'status'       => 'Status',
                    'total'        => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'edit-profile'        => 'Edit Profile',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'email'          => 'E-Mail-Adresse',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'roles'          => 'Roles',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'email'        => 'E-Mail-Adresse',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'status'       => 'Status',
                            'whitelabels'  => 'Whitelabels',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],

        'pages' => [
            'create'     => 'Create Page',
            'edit'       => 'Edit Page',
            'management' => 'Page Management',
            'title'      => 'Pages',

            'table' => [
                'title'     => 'Title',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'updatedat' => 'Updated At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogcategories' => [
            'create'     => 'Create Blog Category',
            'edit'       => 'Edit Blog Category',
            'management' => 'Blog Category Management',
            'title'      => 'Blog Category',

            'table' => [
                'title'     => 'Blog Category',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogtags' => [
            'create'     => 'Create Blog Tag',
            'edit'       => 'Edit Blog Tag',
            'management' => 'Blog Tag Management',
            'title'      => 'Blog Tags',

            'table' => [
                'title'     => 'Blog Tag',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'blogs' => [
            'create'     => 'Create Blog',
            'edit'       => 'Edit Blog',
            'management' => 'Blog Management',
            'title'      => 'Blogs',

            'table' => [
                'title'     => 'Blog',
                'publish'   => 'PublishDateTime',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
        ],

        'wishes' => [
            'create'         => 'Create Wish',
            'edit'           => 'Edit Wish',
            'management'     => 'Wishes',
            'title'          => 'Wishes',
            'no_whitelabels' => 'no Whitelabels',
            'table'          => [
                'title'             => 'Wish',
                'status'            => 'Status',
                'destination'       => 'Destination',
                'airport'           => 'Airport',
                'earliest_start'    => 'Earliest Start',
                'latest_return'     => 'Latest Return',
                'createdat'         => 'Created At',
                'createdby'         => 'Created By',
                'whitelabel'        => 'Whitelabel',
                'group'             => 'Group',
                'offerCount'        => 'Offers',
                'all'               => 'All',
            ],
        ],

        'groups' => [
            'create'         => 'Create Group',
            'edit'           => 'Edit Group',
            'management'     => 'Groups',
            'title'          => 'Groups',
            'no_whitelabels' => 'no Whitelabels',
            'table'          => [
                'name'              => 'Group',
                'display_name'      => 'Display Name',
                'status'            => 'Status',
                'users'             => 'Users',
                'description'       => 'Description',
                'createdat'         => 'Created At',
                'createdby'         => 'Created By',
                'whitelabel'        => 'Whitelabel',
                'all'               => 'All',
            ],
        ],

        'distributions' => [
            'create'           => 'Create Distribution',
            'edit'             => 'Edit Distribution',
            'management'       => 'Distributions',
            'title'            => 'Distributions',
            'no_distributions' => 'no Distributions',
            'table'            => [
                'name'              => 'Distribution',
                'display_name'      => 'Display Name',
                'description'       => 'Description',
                'createdat'         => 'Created At',
                'createdby'         => 'Created By',
                'whitelabel'        => 'Whitelabel',
                'all'               => 'All',
            ],
        ],

        'whitelabels' => [
            'create'            => 'Create Whitelabel',
            'edit'              => 'Edit Whitelabel',
            'management'        => 'Whitelabels',
            'management_client' => 'Whitelabel',
            'title'             => 'Whitelabels',

            'table' => [
                'name'           => 'Identifier',
                'display_name'   => 'Whitelabel',
                'distribution'   => 'Distribution',
                'status'         => 'Status',
                'createdat'      => 'Created At',
                'createdby'      => 'Created By',
                'all'            => 'All',
                'ga_view_id'     => 'Google View Id',
            ],
        ],

        'emailtemplates' => [
            'create'     => 'Create Email Template',
            'edit'       => 'Edit Email Template',
            'management' => 'Email Template Management',
            'title'      => 'Email Templates',

            'table' => [
                'title'     => 'Title',
                'subject'   => 'Subject',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'updatedat' => 'Updated At',
                'all'       => 'All',
            ],
        ],

        'settings' => [
            'edit'           => 'Edit Settings',
            'management'     => 'Settings Management',
            'title'          => 'Settings',
            'seo'            => 'SEO Settings',
            'companydetails' => 'Company Contact Details',
            'mail'           => 'Mail Settings',
            'footer'         => 'Footer Settings',
            'terms'          => 'Terms and Condition Settings',
            'google'         => 'Google Analytics Track Code',
        ],

        'faqs' => [
            'create'     => 'Create FAQ',
            'edit'       => 'Edit FAQ',
            'management' => 'FAQ Management',
            'title'      => 'FAQ',

            'table' => [
                'title'     => 'FAQs',
                'publish'   => 'PublishDateTime',
                'status'    => 'Status',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'answer'    => 'Answer',
                'question'  => 'Question',
                'updatedat' => 'Updated At',
                'all'       => 'All',
            ],
        ],

        'menus' => [
            'create'     => 'Create Menu',
            'edit'       => 'Edit Menu',
            'management' => 'Menu Management',
            'title'      => 'Menus',

            'table' => [
                'name'      => 'Name',
                'type'      => 'Type',
                'createdat' => 'Created At',
                'createdby' => 'Created By',
                'all'       => 'All',
            ],
            'field' => [
                'name'      => 'Name',
                'type'      => 'Type',
                'items'     => 'Menu Items',
                'url'       => 'URL',
                'url_type'  => 'URL Type',
                'url_types' => [
                  'route'  => 'Route',
                  'static' => 'Static',
                ],
                'open_in_new_tab'    => 'Open URL in new tab',
                'view_permission_id' => 'Permission',
                'icon'               => 'Icon Class',
                'icon_title'         => 'Font Awesome Class. eg. fa-edit',
            ],
        ],

        'modules' => [
            'create'     => 'Create Module',
            'management' => 'Module Management',
            'title'      => 'Module',
            'edit'       => 'Edit Module',

            'table' => [
                'name'               => 'Module Name',
                'url'                => 'Module View Route',
                'view_permission_id' => 'View Permission',
                'created_by'         => 'Created By',
            ],

            'form' => [
                'name'                  => 'Module Name',
                'url'                   => 'View Route',
                'view_permission_id'    => 'View Permission',
                'directory_name'        => 'Directory Name',
                'namespace'             => 'Namespace',
                'model_name'            => 'Model Name',
                'controller_name'       => 'Controller &nbsp;Name',
                'resource_controller'   => 'Resourceful Controller',
                'table_controller_name' => 'Controller &nbsp;Name',
                'table_name'            => 'Table Name',
                'route_name'            => 'Route Name',
                'route_controller_name' => 'Controller &nbsp;Name',
                'resource_route'        => 'Resourceful Routes',
                'views_directory'       => 'Directory &nbsp;&nbsp;&nbsp;Name',
                'index_file'            => 'Index',
                'create_file'           => 'Create',
                'edit_file'             => 'Edit',
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
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'passwords' => [
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

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

            'timezone' => 'Timezone',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Erstellt am',
                'edit_information'   => 'Edit Information',
                'email'              => 'E-Mail Adresse',
                'last_updated'       => 'Zuletzt geändert',
                'first_name'         => 'Vorname',
                'last_name'          => 'Nachname',
                'address'            => 'Adresse',
                'country'            => 'Land',
                'city'               => 'Stadt',
                'zipcode'            => 'BLZ',
                'ssn'                => 'SSN',
                'update_information' => 'Profil ändern',
            ],
        ],

        'offers' => [
            'create'          => 'Neues Angebot erstellen',
            'management'      => 'Offers',
            'offers_for_wish' => 'Offer for',
            'table'           => [
                'title'     => 'Offer',
                'status'    => 'Status',
                'createdat' => 'Erstellt in',
                'createdby' => 'Erstellt von',
                'all'       => 'All',
            ],
        ],

        'agents' => [
            'create'     => 'Create new Agent',
            'management' => 'Agenten',
            'table'      => [
                'avatar'           => 'Avatar',
                'name'             => 'Name',
                'display_name'     => 'Display name',
                'status'           => 'Status',
                'created_at'       => 'Erstellt am',
                'createdby'        => 'Erstellt von',
                'id'               => 'Id',
            ],
        ],
        'wishes' => [
            'wishes'        => 'Reisewünsche',
            'goto'          => 'Reisewunsch ansehen',
            'created_at'    => 'erstellt am',
            'edit'          => 'Edit wish',
            'add-comment'   => 'Add comment',
            'week'          => ':value Woche|:value Wochen',
            'night'         => ':value Nacht|:value Nächte',
            'table'         => [
                'adults' => 'Erwachsener|Erwachsene',
                'kids'   => '{0}|Kind|Kinder',
            ]
        ],
        'dashboard' => [
            'analytics' => [
                'created_wishes'         => 'Created Wishes',
                'changed_wishes'         => 'Changed Wishes',
                'free_text'              => 'Free text',
                'answered_wishes'        => 'Answered Wishes',
                'reaction_quota'         => 'Reaction Quota',
                'latest_answered_wishes' => 'Latest Answered Wishes',
                'latest_reaction_quota'  => 'Latest Reaction Quota',
                'bookings'               => 'Bookings',
                'reaction_time'          => 'Reaction Time'
            ]
        ]
    ],
    'wish'                     => 'Wish',
    'wishes'                   => 'Wishes',
    'id'                       => 'Id',
    'name'                     => 'Name',
    'title'                    => 'Title',
    'username'                 => 'Username',
    'first_name'               => 'Fisrtname',
    'last_name'                => 'Lastname',
    'full_name'                => 'Full Name',
    'email'                    => 'Email',
    'country'                  => 'Country',
    'password_confirm'         => 'Confirm Password',
    'current_password'         => 'Current Password',
    'language'                 => 'Language',
    'about'                    => 'About us',
    'interest'                 => 'Interet',
    'personal_timezone'        => 'Timezone',
    'occupation'               => 'Occupation',
    'activated'                => 'activated',
    'tel'                      => 'Numero de Telephone',
    'fax'                      => 'Fax',
    'street'                   => 'Street',
    'zipcode'                  => 'Zip',
    'ok'                       => 'Ok',
    'cancel'                   => 'Cancel',
    'warning'                  => 'Warning',
    'online'                   => 'Online',
    'user'                     => 'User',
    'documents'                => 'Documents',
    'login'                    => 'Sign',
    'logout'                   => 'Logout',
    'register'                 => 'Register',
    'join'                     => 'Join Now',
    'now'                      => 'Now',
    'plus'                     => 'More',
    'new'                      => 'New',
    'posts'                    => 'Posts',
    'events'                   => 'Events',
    'feedback'                 => 'Feedback',
    'name'                     => 'Name',
    'email'                    => 'E-Mail-Adresse',
    'subject'                  => 'Subject',
    'recipient'                => 'Recipient',
    'message'                  => 'Message',
    'password'                 => 'Passwort',
    'send'                     => 'Send Now',
    'verify'                   => 'Email Verification',
    'verify_email'             => 'Verify Your Email Address',
    'reset'                    => 'Reset Password',
    'reset_link'               => 'Send Password Reset Link',
    'contact'                  => 'Contact',
    'mobile'                   => 'Mobile',
    'phone'                    => 'Phone',
    'message_text'             => 'Message text',
    'notes'                    => 'notes',
    'address'                  => 'Address',
    'note'                     => 'note',
    'notes'                    => 'notes',
    'account'                  => 'Account',
    'download'                 => 'Download',
    'details'                  => 'Details',
    'attendee'                 => 'Attendee',
    'attendees'                => 'Attendees',
    'description'              => 'Description',
    'content'                  => 'Content',
    'review'                   => 'Review',
    'ratings'                  => 'Ratings',
    'current'                  => 'Aktuell',
    'logo'                     => 'Logo',
    'domain'                   => 'Domain',
    'whitelabel_information'   => 'White-Label Informationen',
    'whitelabel_executive'     => 'White-Label Executive',
    'go_next'                  => 'Weiter!',
    'go_back'                  => 'Zurück!',
    'finish'                   => 'Fertig',
    'whitelabel_title'         => 'Neuer Whitelabel',
    'whitelabel_subtitle'      => 'Ein neuer Untertitel',
    'notifications'            => 'Benachrichtigungen',
    'inbox'                    => 'Posteingang',
    'whitelabel'               => 'Whitelabel',
    'role'                     => 'Rolle',
];
