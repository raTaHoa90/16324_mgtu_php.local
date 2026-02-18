<?php

session_name('MGTU_SES');
$age = time() + 30 * 60;
ini_set('session.cookie_lifetime', $age);
session_set_cookie_params(30 * 60);
session_cache_expire($age);

if(isset($_COOKIE[session_name()]))
    setcookie(session_name(), $_COOKIE[session_name()], $age, '/');

session_start();

function reStartSession(){
    session_unset();   // уничтожить все переменные сессии
    session_destroy(); // уничтожить файл сессии
    //session_regenerate_id(true);
}