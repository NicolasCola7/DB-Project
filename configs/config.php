<?php
// questo file serve per gestire le variabli d'ambiente del progetto e settare le credenziali del db con esse

require_once __DIR__ . '/../vendor/autoload.php'; //

// carico variabbili d'ambiente da .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$config = [
    'db_host'     => isset($_ENV['MYSQL_DB_HOST']) ? $_ENV['MYSQL_DB_HOST'] : 'localhost',
    'db_name'     => isset($_ENV['MYSQL_DB_NAME']) ? $_ENV['MYSQL_DB_NAME'] : 'your_database',
    'db_user'     => isset($_ENV['MYSQL_DB_USER']) ? $_ENV['MYSQL_DB_USER'] : 'your_username',
    'db_password' => isset($_ENV['MYSQL_DB_PASS']) ? $_ENV['MYSQL_DB_PASS'] : 'your_password',
];

return $config;

