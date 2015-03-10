<?php
require_once __DIR__ . "/../bootstrap.php";

$app->get('/', function () use ($app, $data) {
    $app->render("index.twig", $data);
});

$app->get('/login', function () use ($app) {
    $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
    if (!$openid->mode) {
        $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
        $openid->identity = 'http://steamcommunity.com/openid/?l=russian';
        $app->redirect($openid->authUrl());
    } else if ($openid->mode != 'cancel') {
        if ($openid->validate()) {
            $id = $openid->identity;
            $ptn = "/^http:\\/\\/steamcommunity\\.com\\/openid\\/id\\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);
            $_SESSION['steamId'] = $matches[1];
        }
    }
    $app->redirect("/");
});

$app->get('/logout', function () use ($app) {
    session_destroy();
    $app->deleteCookie("REMEMBER_ME");
    $app->redirect("/");
});

$app->get('/user/checkForAdmin', function () use ($app, $entityManager, $data) {
    //TODO this method looks like a mess. u probably want to have a controller finally
    if (!isset($_SESSION['user']['u']))
        $app->redirect("/");
    $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");
    $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));

    if ($user != null) {
        if (!$user->isTooManyChecks()) {
            $request = $user->checkForAdmin();
            if ($request !== false) {
                $entityManager->persist($request);
                $entityManager->flush();
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $data['validated'] = $request !== false && $request->getValidated();
        }
        $app->render("user.validation.twig", $data);
    } else {
        $app->redirect("/");
    }
});

$app->run();

