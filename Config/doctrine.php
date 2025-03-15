<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$paths =  [__DIR__ . '/../config/mappings'];

$config = ORMSetup::createXMLMetadataConfiguration($paths,true);


$connection = DriverManager::getConnection([
    'dbname'   => $_ENV['DB_NAME'] ?? 'my_database',
    'user'     => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? 'root',
    'host'     => $_ENV['DB_HOST'] ?? 'mysql',
    'driver'   => 'pdo_mysql',
], $config);

$entityManager = new EntityManager($connection, $config);

return $entityManager;