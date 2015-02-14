<?php

require 'vendor/autoload.php';
require_once 'config/config.php';

session_cache_limiter(false);
session_start();

$entitiesPath = array(__DIR__ . '/src/Entity');
$config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($entitiesPath);
$entityManager = Doctrine\ORM\EntityManager::create($dbParams, $config);

$app = new \Slim\Slim(array(
        'view' => new \Slim\Views\Twig(),
        'cookies.httponly' => true
    )
);

$app->view()->setTemplatesDirectory('../templates');

$data = array();

//auth check, no output!
if (strlen($app->getCookie("REMEMBER_ME")) == 40) {
    $app->setCookie("REMEMBER_ME", $app->getCookie("REMEMBER_ME"), "30 days");
    $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");

    $user = $userRepository->findOneBy(array("cookie" => $app->getCookie("REMEMBER_ME")));
    if ($user == null) {//let's check if he is new one
        if (isset($_SESSION['steamId']) && !isset($_SESSION['userId'])) {//
            $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));
            if($user == null){
                $user = new WebApp\Entity\User();
                $user->setName("user");
                $user->setSteamId($_SESSION['steamId']);
            }

            $user->setCookie($app->getCookie("REMEMBER_ME"));
            $user->setLastIp($app->request()->getIp());

            $entityManager->persist($user);
            $entityManager->flush();
            $_SESSION['userId'] = $user->getId();
        } else {
            // he is hacker
        }
    } else {
        $_SESSION['userId'] = $user->getId();
    }
    $data['user']['userId'] = $_SESSION['userId'];

} else {
    $app->deleteCookie("REMEMBER_ME");
}