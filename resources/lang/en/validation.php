<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => 'The :attribute must be accepted.',
    'active_url'      => 'The :attribute is not a valid URL.',
    'after'           => 'The :attribute must be a date after :date.',
    'after_or_equal'  => 'The :attribute must be a date after or equal to :date.',
    'alpha'           => 'The :attribute may only contain letters.',
    'alpha_dash'      => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'       => 'The :attribute may only contain letters and numbers.',
    'array'           => 'The :attribute must be an array.',
    'before'          => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between'         => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'        => 'The :attribute field must be true or false.',
    'confirmed'      => 'The :attribute confirmation does not match.',
    'date'           => 'The :attribute is not a valid date.',
    'date_format'    => 'The :attribute does not match the format :format.',
    'different'      => 'The :attribute and :other must be different.',
    'digits'         => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions'     => 'The :attribute has invalid image dimensions.',
    'distinct'       => 'The :attribute field has a duplicate value.',
    'email'          => 'The :attribute must be a valid email address.',
    'exists'         => 'The selected :attribute is invalid.',
    'file'           => 'The :attribute must be a file.',
    'filled'         => 'The :attribute field must have a value.',
    'image'          => 'The :attribute must be an image.',
    'in'             => 'The selected :attribute is invalid.',
    'in_array'       => 'The :attribute field does not exist in :other.',
    'integer'        => 'The :attribute must be an integer.',
    'ip'             => 'The :attribute must be a valid IP address.',
    'json'           => 'The :attribute must be a valid JSON string.',
    'max'            => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'     => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min'       => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'   => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique'   => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url'      => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'backend' => [
            'access' => [
                'permissions' => [
                    'associated_roles' => 'Associated Roles',
                    'dependencies'     => 'Dependencies',
                    'display_name'     => 'Display Name',
                    'group'            => 'Group',
                    'group_sort'       => 'Group Sort',
                    'name'             => 'Name',
                    'sort'             => 'Sort',

                    'groups' => [
                        'name' => 'Group Name',
                    ],

                    'name'   => 'Name',
                    'system' => 'System?',
                ],

                'roles' => [
                    'associated_permissions' => 'Associated Permissions',
                    'name'                   => 'Name',
                    'sort'                   => 'Sort',
                    'active'                 => 'Active',
                ],

                'users' => [
                    'active'                  => 'Active',
                    'associated_roles'        => 'Associated Roles',
                    'groups'                  => 'User Groups',
                    'associated_whitelabels'  => 'Associated Whitelabels',
                    'confirmed'               => 'Confirmed',
                    'email'                   => 'E-mail Address',
                    'firstName'               => 'First Name',
                    'lastName'                => 'Last Name',
                    'other_permissions'       => 'Other Permissions',
                    'old_password'            => 'Old password',
                    'password'                => 'New Password',
                    'password_confirmation'   => 'New Password Confirmation',
                    'send_confirmation_email' => 'Send Confirmation E-mail',
                    'no-group'                => 'None',
                ],
            ],
            'pages' => [
                'title'           => 'Title',
                'description'     => 'Description',
                'cannonical_link' => 'Cannonical Link',
                'seo_title'       => 'SEO Title',
                'seo_keyword'     => 'SEO Keyword',
                'seo_description' => 'SEO Description',
                'is_active'       => 'Active',
            ],

            'blogcategories' => [
                'title'     => 'Blog Category',
                'is_active' => 'Active',
            ],

            'blogtags' => [
                'title'     => 'Blog Tag',
                'is_active' => 'Active',
            ],

            'blogs' => [
                'title'            => 'Blog Title',
                'category'         => 'Blog Category',
                'publish'          => 'Publish Date & Time',
                'image'            => 'Featured Image',
                'content'          => 'Content',
                'tags'             => 'Tags',
                'meta-title'       => 'Meta Title',
                'slug'             => 'Slug',
                'cannonical_link'  => 'Cannonical Link',
                'meta_keyword'     => 'Meta Keyword',
                'meta_description' => 'Meta Description',
                'status'           => 'Status',
            ],

            'wishes' => [
                'title'                       => 'Wish Title',
                'image'                       => 'Featured Image',
                'description'                 => 'Description',
                'status'                      => 'Status',
                'airport'                     => 'Airport',
                'destination'                 => 'Destination',
                'earliest_start'              => 'Earliest start',
                'latest_return'               => 'Latest return',
                'adults'                      => 'Adults',
                'kids'                        => 'Kids',
                'budget'                      => 'Budget',
                'category'                    => 'Hotel category',
                'catering'                    => 'Hotel catering',
                'duration'                    => 'Duration',
                'associated_whitelabels'      => 'Associated Whitelabels',
            ],

            'groups' => [
                'name'                        => 'Group Name',
                'display_name'                => 'Display Name',
                'description'                 => 'Description',
                'status'                      => 'Status',
                'associated_whitelabels'      => 'Associated Whitelabels',
                'groups'                      => 'Seller Groups',
            ],

            'distributions' => [
                'name'             => 'Name',
                'display_name'     => 'Display Name',
                'description'      => 'Description',
            ],

            'whitelabels' => [
                'name'                         => 'Name',
                'display_name'                 => 'Display Name',
                'status'                       => 'Status',
                'associated_distribution'      => 'Associated Distribution',
                'image'                        => 'Background Image',
                'ga_view_id'                   => 'Google View Id'
            ],

            'settings' => [
                'sitelogo'        => 'Site Logo',
                'favicon'         => 'Fav Icon',
                'metatitle'       => 'Meta Title',
                'metakeyword'     => 'Meta Keyawords',
                'metadescription' => 'Meta Description',
                'companydetails'  => [
                    'address'       => 'Company Address',
                    'contactnumber' => 'Contact Number',
                ],
                'mail' => [
                    'fromname'  => 'From Name',
                    'fromemail' => 'From Email',
                ],
                'footer' => [
                    'text'      => 'Footer Text',
                    'copyright' => 'Copyright Text',
                ],
                'termscondition' => [
                    'terms'      => 'Terms & Condition',
                    'disclaimer' => 'Disclaimer',
                ],
                'google' => [
                    'analytic' => 'Google Analytics',
                ],
            ],
            'faqs' => [
                    'question' => 'Question',
                    'answer'   => 'Answer',
                    'status'   => 'Status',
            ],
        ],

        'frontend' => [
            'register-user' => [
                'email'                     => 'E-mail Adresse',
                'firstName'                 => 'Vorname',
                'lastName'                  => 'Nachname',
                'password'                  => 'Passwort',
                'address'                   => 'Adresse',
                'country'                   => 'Land',
                'state'                     => 'State',
                'city'                      => 'Stadt',
                'zipcode'                   => 'BLZ',
                'ssn'                       => 'SSN',
                'password_confirmation'     => 'Passwort Bestätigung',
                'old_password'              => 'Altes Passwort',
                'new_password'              => 'Neues Passwort',
                'new_password_confirmation' => 'Neue Passwort Bestätigung',
                'terms_and_conditions'      => 'Geschäftsbedingungen',
                'user_type'                 => 'I use desiretec as a',
                'user_type_user'            => 'User',
                'user_type_seller'          => 'Seller',
            ],
            'offers' => [
                'title'                 => 'Angebotstitel',
                'text'                  => 'Nachricht',
                'status'                => 'Status',
                'file'                  => 'Datei',
                'link'                  => 'Link',
                'title_placeholder'     => 'Kurze Beschreibung des Angebotes',
                'text_placeholder'      => 'Ihre Nachricht an den Kunder',
                'status_placeholder'    => 'Status',
                'file_placeholder'      => 'File',
                'link_placeholder'      => 'http://goo.gl/rxozgv',
                'select_file'           => 'Wähle eine Datei'
            ],
        ],
    ],

    'api' => [
        'login' => [
            'email_required'                => 'Please enter email',
            'valid_email'                   => 'Please enter valid email address.',
            'password_required'             => 'Please enter passsword.',
            'username_password_didnt_match' => 'Please enter valid credentials.',
        ],

        'forgotpassword' => [
            'email_required'  => 'Please enter email',
            'valid_email'     => 'Please enter valid email address.',
            'email_not_valid' => 'Email you entered is not register with fin builders.',
        ],

        'resetpassword' => [
            'email_required'            => 'Please enter email',
            'valid_email'               => 'Please enter valid email address.',
            'password_required'         => 'Please enter passsword.',
            'password_confirmed'        => 'passsword and confirm passsword do not match.',
            'token_required'            => 'Please enter token.',
            'confirm_password_required' => 'Please enter confirm password.',
            'token_not_valid'           => 'Given token is invalid.',
            'email_not_valid'           => 'Email you entered is not register with fin builders.',
        ],
        'register' => [
            'state_required' => 'Please enter state.',
            'city_required'  => 'Please enter city.',
        ],
        'confirmaccount' => [
           'already_confirmed' => 'Account is already confirmed.',
           'invalid_otp'       => 'Please enter valid otp.',
            'invalid_email'    => 'Email is not register with fin builders',
        ],
    ],
];
