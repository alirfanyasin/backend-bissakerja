<?php

/*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

return [
  'paths' => [
    'api/*',
    'sanctum/csrf-cookie',
    'login',
    'logout',
    'register'
  ],

  'allowed_methods' => ['*'],

  'allowed_origins' => [
    'http://31.97.48.147:3000',
    'http://31.97.48.147:3001',
    'http://localhost:3000',
    'http://localhost:3001'
  ],

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => [],

  'max_age' => 0,

  'supports_credentials' => true,
];
