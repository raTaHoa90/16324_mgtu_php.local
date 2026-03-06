<?php

function GET_default(){
    $menu = include 'menu/main.php';
    view('default', [
        'caption' => 'Сайт для вашего портфолио',
        'menu' => $menu
    ]);
}