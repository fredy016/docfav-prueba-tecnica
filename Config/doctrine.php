<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$paths = [__DIR__ . '/mappings'];

echo __DIR__ . '/migrations.php';

$isDev = $_ENV['APP_ENV'] === "dev";

$config = ORMSetup::createXMLMetadataConfiguration($paths, $isDev);

$connection = DriverManager::getConnection([
    'dbname'   => $_ENV['MYSQL_DATABASE'] ?? 'docfav',
    'user'     => $_ENV['MYSQL_USER'] ?? 'user',
    'password' => $_ENV['MYSQL_PASSWORD'] ?? 'password',
    'host'     => $_ENV['HOST'] ?? 'db_app',
    'driver'   => 'pdo_mysql'
], $config);

$entityManager = new EntityManager($connection, $config);

$migrationConfig = new PhpFile(__DIR__ . './migrations.php');
$dependencyFactory = DependencyFactory::fromEntityManager(
    $migrationConfig,
    new ExistingEntityManager($entityManager)
);
return $entityManager;