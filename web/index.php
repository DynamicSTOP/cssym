<?php
require_once __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../functions.php";

$app->get('/', function () use ($app) {
    if(class_exists("Memcache")) {
        $mc = new Memcache();
        if ($mc->connect('127.0.0.1', 11211) !== false) {
            if ($mc->get('curl_csgo') !== false) {
                $news = json_decode($mc->get('curl_csgo'));
                if($news!==false){
                    foreach($news as &$newsItem){
                        $newsItem->date=date("j M",$newsItem->date);
                    }
                    unset($newsItem);
                    //date("h-M-s",$news[0]->date);
                    $app->view()->appendData(['news_items'=>$news]);
                }
            }
        }
    }
    $app->render("index.twig");
});

$app->get('/login', function () use ($app) {
    $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
    $url = "/";
    if (!$openid->mode) {
        try {
            $openid = new LightOpenID("http://{$_SERVER['HTTP_HOST']}/login");
            $openid->identity = 'http://steamcommunity.com/openid/?l=russian';
            $url = $openid->authUrl();
        } catch (\Exception $e) {
            $url = "/technicalIssues";
        }
    } else if ($openid->mode != 'cancel') {
        if ($openid->validate()) {
            $id = $openid->identity;
            $ptn = "/^http:\\/\\/steamcommunity\\.com\\/openid\\/id\\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);
            $_SESSION['steamId'] = $matches[1];
            if (isset($_SESSION['redirect'])) {
                $url = $_SESSION['redirect'];
                unset($_SESSION['redirect']);
            }
        }
    }
    $app->redirect($url);
});

$app->get('/logout', function () use ($app) {
    session_destroy();
    $app->deleteCookie("REMEMBER_ME");
    $app->redirect("/");
});

$app->group('/user', $redirectIfNotLoggedIn, function () use ($app, $entityManager) {

    $app->get('/refresh', function() use($app,$entityManager){
        // TODO restrict more than 3 refresh actions per 24 hours
        $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");
        $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));
        if($user!=null){
            $user->updateFromSteam();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $app->redirect("/");
    });

    $app->post('/checkForAdmin', function () use ($app, $entityManager) {
        //TODO this method looks like a mess. u probably want to have a controller finally
        $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");
        $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));

        if ($user != null && strtolower(trim($app->request()->get("i_confirm")))=='я подтверждаю') {
            if (!$user->isTooManyChecks()) {
                $request = $user->checkForAdmin();
                if ($request !== false) {
                    $entityManager->persist($request);
                    $entityManager->flush();
                }
                $entityManager->persist($user);
                $entityManager->flush();
                $app->view()->appendData(['validated' => $request !== false && $request->getValidated()]);
            }
            $app->render("user/validation.twig");
        } else {
            $app->redirect("/");
        }
    });

    $app->get('/rememberMe', function() use($app){
        $app->render("user/rememberMe.twig");
    });

    $app->get('/statistic', function() use($app){
        $app->render("user/statistic.twig");
    });

    $app->group('/request',function()use($app,$entityManager){
        $app->get('/adminRights', function() use($app){
            $app->render("user/request/adminRights.twig");
        });

        $app->get('/newMap', function() use($app){
            $app->render("user/request/newMap.twig");
        });

        $app->post('/newMap', function() use($app,$entityManager){
            $mapName=trim($app->request()->post("mapName"));
            $workshopLink=trim($app->request()->post("workshopLink"));
            if(!empty($mapName) || !empty($workshopLink)){
                $userRepository = $entityManager->getRepository("\\WebApp\\Entity\\User");
                $user = $userRepository->findOneBy(array("steamId" => $_SESSION['steamId']));
                $mapRequest = new \WebApp\Entity\UserMapRequest();
                $mapRequest->setUser($user);
                $mapRequest->setWorkshopLink($workshopLink);
                $mapRequest->setMapName($mapName);
                $entityManager->persist($mapRequest);
                $entityManager->flush();
                $app->view()->appendData(['added'=>true]);
            }
            $app->render("user/request/newMap.twig");
        });



        $app->get('/unban', function() use($app){
            $app->render("user/request/unban.twig");
        });
        $app->get('/list', function() use($app){
            $app->render("user/request/list.twig");
        });
    });

    $app->group('/abuse', function() use($app){
        $app->get('/player', function() use($app){
            $app->render("user/abuse/player.twig");
        });
        $app->get('/admin', function() use($app){
            $app->render("user/abuse/admin.twig");
        });
        $app->get('/list', function() use($app){
            $app->render("user/abuse/list.twig");
        });
    });
});


$app->group('/faq', function () use ($app) {
    $app->get('/server', function () use ($app) {
        $app->render("faq/server.twig");
    });
    $app->get('/rules', function () use ($app) {
        $app->render("faq/rules.twig");
    });
    $app->get('/unban', function () use ($app) {
        $app->render("faq/unban.twig");
    });
    $app->get('/copyright', function () use ($app) {
        $app->render("faq/copyright.twig");
    });
});

$app->get("/technicalIssues", function () use ($app) {
    $app->render("technicalIssues.twig");
});

$app->run();

