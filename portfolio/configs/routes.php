<?php

return [
    'GET' => [
        'admin' => [
            '<<default>>' => 'admin/main.php',
            'auth' => 'admin/auth.php',
            'logout' => 'admin/auth.php',
            'profile' => 'admin/profile.php',
            'catalogs' => 'admin/catalogs.php'
        ],
        'main' => [
            'one' => 'main.php',
            'two' => 'main.php',
            '<<default>>' => 'main.php'
        ],
        'users' => [
            '<<default>>' => 'users.php',
            '@login' => [
                '<<default>>' => 'user.php'
            ]
        ],
        '<<default>>' => 'default.php'
    ],

    'POST' => [
        'admin' => [
            'auth' => 'admin/auth.php',
            'profile' => 'admin/profile.php',
            'catalogs' => [
                'getCatalogs' => 'admin/catalogs.php',
                'createDir' => 'admin/catalogs.php',
                'uploadFile' => 'admin/catalogs.php'
            ]
        ],
    ]
];