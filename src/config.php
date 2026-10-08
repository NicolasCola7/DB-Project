<?php

return [
    'databases' => [
        'mysql' => [
            'host'     => 'db-project-mysql-1',
            'nome_db'  => 'BOSTARTER',
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset'  => 'utf8'
        ],
        'mongo' => [
            'host'     => 'db-project-mongodb-1',
            'nome_db'  => 'BOSTARTER',
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD')
        ]
    ]
];

