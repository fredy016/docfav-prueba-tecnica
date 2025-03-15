<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
return [
    'dbname'   => $_ENV['MYSQL_DATABASE'] ?? 'docfav',
    'user'     => $_ENV['MYSQL_USER'] ?? 'user',
    'password' => $_ENV['MYSQL_PASSWORD'] ?? 'password',
    'host'     => $_ENV['HOST'] ?? 'db_app',
    'driver'   => 'pdo_mysql'
];