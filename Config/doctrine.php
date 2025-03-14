<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/../src/Domain'],
    isDevMode: true
);

$connection = DriverManager::getConnection([
    'dbname'   => $_ENV['DB_NAME'] ?? 'my_database',
    'user'     => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? 'root',
    'host'     => $_ENV['DB_HOST'] ?? 'mysql',
    'driver'   => 'pdo_mysql',
], $config);

$entityManager = new EntityManager($connection, $config);

return $entityManager;