<?php

function GET_default(){
    $menu = include 'menu/main.php';
    $users = loadModel('users');

    view('users/table', [
        'caption' => 'Все пользователи',
        'menu' => $menu,
        'users' => $users
    ]);
}