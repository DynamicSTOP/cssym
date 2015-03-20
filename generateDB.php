<?php
require 'vendor/autoload.php';
require_once 'config/config.php';

session_cache_limiter(false);
session_start();

use \DoctrineExtensions\NestedSet;
use \WebApp\Entity;

$entitiesPath = array(__DIR__ . '/src/Entity');
$config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($entitiesPath);
$entityManager = Doctrine\ORM\EntityManager::create($dbParams, $config);

$config = new NestedSet\Config($entityManager, '\WebApp\Entity\UserRole');
$nsm = new NestedSet\Manager($config);


$SuperAdminRole = new Entity\UserRole();
$SuperAdminRole->setRole("SUPER_ADMIN");
$rootNode = $nsm->createRoot($SuperAdminRole);

$AdminRole = new Entity\UserRole();
$AdminRole->setRole("ADMIN");

$adminNode = $rootNode->addChild($AdminRole);

$UserRole = new Entity\UserRole();
$UserRole->setRole("USER");
$adminNode->addChild($UserRole);

echo "\nRoles added\n";