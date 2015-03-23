<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../functions.php";

$app->get("/",function() use ($app){
    $app->redirect("/");
});

$app->run();