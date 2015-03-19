<?php

if (class_exists("Memcache")) {
    $mc = new Memcache();
    if ($mc->connect('127.0.0.1', 11211) !== false){
        if($mc->get('curl_csgo')===false){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://api.steampowered.com/ISteamNews/GetNewsForApp/v0001/?format=json&appid=730&count=3');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3'
            ));
            $answer = curl_exec($ch);
            $json_news = json_decode($answer);
            if($json_news!==false){
                echo "setted\n";
                $mc->set('curl_csgo',json_encode($json_news->appnews->newsitems->newsitem),MEMCACHE_COMPRESSED,3600);
            }
        } else {
            echo "in memcache\n";
        }

    }
}

