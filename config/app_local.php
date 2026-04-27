<?php

use function Cake\Core\env;

/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => false,

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '14543b5377542174a6ae5ab100fe9650bfb7d14398a4fa1d42c710266b1ba543'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => 'u26s1158_root',
            'password' => 'fit3047root',

            'database' => 'u26s1158_fit3047_review',
            /*
             * If not using the default 'public' schema with the PostgreSQL driver
             * set it here.
             */
            //'schema' => 'myapp',

            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => 'localhost',
            'port' => 25,
            'username' => 'noreply@review.fit3047.u26s1158.iedev.org',
            'password' => 'MovingHouse247!',
            'tls' => false,
            'client' => null,
        ],
    ],
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => ['noreply@review.fit3047.u26s1158.iedev.org' => 'Moving House 24/7'],
        ],
    ],
    'Stripe' => [
        'secretKey' => 'REDACTED_STRIPE_TEST_KEY',
        'webhookKey' => 'whsec_IjIGii1fFvCdNgAkjfNrHSqbI77K7PsW',
    ],
    'Recaptcha' => [
        'siteKey' => "6Lds85QsAAAAAEEWmyp2mWR9ITmNyAwoLeECRwAs",
        'secretKey' => "6Lds85QsAAAAAEgTCP--6NvRs-HwEGUoj2C3qXJH",
    ],
];
