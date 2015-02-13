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
    $app->render("index.html.twig");
});

$app->get('/login', function () use ($app) {
    $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
    if(!$openid->mode){
        $app->render("login.html.twig");
    } else if($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if ($openid->validate()) {
            $app->
            $id = $openid->identity;
            var_dump($openid);
        } else {
            echo 'not valid';
        }
    }

});

$app->post('/login', function () use ($app){
    $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
    $openid->identity = 'http://steamcommunity.com/openid/?l=russian';
    $app->redirect($openid->authUrl());
});

$app->run();

