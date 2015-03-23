<?php

$redirectIfNotLoggedIn = function (\Slim\Route $route) use ($app) {
    if (!isset($_SESSION['userId'])) {
        $_SESSION['redirect'] = $route->getPattern();
        $app->redirect("/login");
    };
};
