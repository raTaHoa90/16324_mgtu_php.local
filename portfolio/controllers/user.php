<?php

function GET_default($params){
    $menu = include 'menu/main.php';
    $user = getUserByLogin($params['login']);
    
    if($user === null)
        redirect('/users');

    view('users/simple', [
        'caption' => 'Профиль: '. ($user['fio'] ?: $user['login'] ),
        'menu' => $menu,
        'user' => $user
    ]);
}

/*

    $var1 ?? $value => isset($var1) ? $var1 : $value
    $var1 ?: $value => $var1 ? $var1 : $value
*/