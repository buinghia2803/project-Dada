<?php

return [
    'authorization' => env('AUTHORIZATION', true),
    // Token expired
    'token_expired' => 5256000, // 10 years
    'paginate' => 50,
    'admin_role' => 'admin',
    'local_upload' => env('LOCAL_PUBLIC_FOLDER', '/uploads'),
    'guard_web' => 'web',
    'guard_api' => 'api',
    'admin_id' => env('ADMIN_ID', 1),
    'client_domain' => env('CLIENT_DOMAIN', 'http://localhost:3000'),
    'time_limit_reset_pass' => 1*60*60*24,
];
