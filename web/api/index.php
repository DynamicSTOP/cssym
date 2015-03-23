<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../functions.php";

$app->get("/", function () use ($app) {
    $app->redirect("/");
});

$app->group("/categories", $redirectIfNotLoggedIn, function () use ($app, $entityManager) {
    $app->get("/", function () use ($app, $entityManager) {

    });
});

$app->group("/topics", $redirectIfNotLoggedIn, function () use ($app, $entityManager) {
    $app->get("/", function () use ($app, $entityManager) {

    });
});

$app->run();