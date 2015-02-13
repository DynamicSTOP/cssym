<?php
require '../vendor/autoload.php';

session_cache_limiter(false);
session_start();

$app = new \Slim\Slim(array(
        'view' => new \Slim\Views\Twig()
    )
);

$app->view()->setTemplatesDirectory('../templates');
/* routes */

$app->get('/', function () use ($app) {
    $app->render("index.twig");
});

$app->get('/login', function () use ($app) {
    $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
    if(!$openid->mode){
        $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
        $openid->identity = 'http://steamcommunity.com/openid/?l=russian';
        $app->redirect($openid->authUrl());
    } else if($openid->mode == 'cancel') {
        $app->redirect("/");
    } else {
        if ($openid->validate()) {
            $id = $openid->identity;
            var_dump($id);
        } else {
            $app->redirect("/");
        }
    }
});

$app->run();

