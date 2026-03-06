<?php

function GET_default(){
    $menu = include 'menu/admin.php';
    $user = AutoAuth();
    if($user === null)
        redirect('/admin/auth');

    view('admin/main', [
        'caption' => 'Панель администратора',
        'menu' => $menu
    ]);
}