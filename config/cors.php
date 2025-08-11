<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

  'paths' => [
    'api/*',
    'sanctum/csrf-cookie',
    'login',
    'logout',
    'register'
  ],

  'allowed_methods' => ['*'],

  'allowed_origins' => [
    env('FRONTEND_AUTH_URL', 'http://localhost:3000'),
    env('FRONTEND_BISSA_KERJA_URL', 'http://localhost:3001')
  ],

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => [],

  'max_age' => 0,

  'supports_credentials' => true,

];
