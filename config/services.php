<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
	    'client_id'     => '485599513055-g0is4gopsti8o8s4bbefsjgf9h62a8ej.apps.googleusercontent.com',
		'client_secret' => 'YvVmy6OgSHpIMlfs8Q5br9d7',
		'redirect'      => '/callback/google',
	],
		
	'facebook' => [
     'client_id' => '484057442165017',
     'client_secret' => 'eeafe1a58b42aa4461be4305f71970fc',
     'redirect' => 'https://tamtmaya.com/callback/facebook',
   ], 

];
