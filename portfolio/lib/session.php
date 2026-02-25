<?php

function core_start_session(){
    session_name(config('session.name', 'MGTU_SES'));
    $timeout = config('session.timeout', 60 * 60);
    $age = time() + $timeout;
    ini_set('session.cookie_lifetime', $age);
    session_set_cookie_params($timeout);
    session_cache_expire($age);

    if(isset($_COOKIE[session_name()]))
        setcookie(session_name(), $_COOKIE[session_name()], $age, '/');

    session_start();
}

function reStartSession(){
    session_unset();   // уничтожить все переменные сессии
    session_destroy(); // уничтожить файл сессии
    //session_regenerate_id(true);
}