<?php
require '../vendor/autoload.php';

$app = new \Slim\Slim(array(
        'view' => new \Slim\Views\Twig()
    )
);

$app->view()->setTemplatesDirectory('../templates');

$app->get('/', function () use ($app) {
    $app->render("index.html.twig");
});

$app->get('/login', function () use ($app) {
    $app->render("login.html.twig");
});

$app->run();

