<?php

return [

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost:5173,localhost:8000,127.0.0.1:5173,127.0.0.1:8000')),

    'guard' => ['web'],

    'expiration' => null,

];

