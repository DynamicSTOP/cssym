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

//this should prevent dozens of ($a,$b,$c,$d,$e..) in use closure
if (isset($_SESSION['steamId'])) {//new user?
    $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");
    $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));

    if (!isset($_SESSION['userId'])) {//fresh login
        if ($user == null) {//well it's new one
            $user = new WebApp\Entity\User();
            $user->setName("user");
            $user->setSteamId($_SESSION['steamId']);
        }
        $user->setLastIp($app->request()->getIp());
        $user->setLastLoginDate(new \DateTime());
        $user->updateFromSteam();

        $entityManager->persist($user);
        $entityManager->flush();
        $_SESSION['userId'] = $user->getId();
        $_SESSION['steamId'] = $user->getSteamId();
    }
    if ($user == null) {
        session_destroy();
        header("Location: /");
        die();
    } else {
        $app->view()->setData(
            [
                'user' => [
                    'name' => $user->getName(),
                    'avatar' => $user->getAvatar(),
                    'role' => $user->getRole(),
                    //TODO show only opened
                    'adminRequestTotally' => $user->getAdminRequests()->count()
                ]
            ]
        );
    }
}


//i'll think about it later ^^
/*
if (count($app->getCookie("REMEMBER_ME"))>0) {
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $text = "";
    $crypt = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key , $text, MCRYPT_MODE_CBC, $iv));
    $text = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key , base64_decode($crypt), MCRYPT_MODE_CBC, $iv);


    $app->setCookie("REMEMBER_ME", $app->getCookie("REMEMBER_ME"), "30 days");

} else {
    $app->deleteCookie("REMEMBER_ME");
}
*/