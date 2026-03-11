<?php

use DATA\Users;
use lib\SYS;

$menu = [
    ['caption' => 'Назад на сайт', 'icon' => 'fa-home', 'url' => '/'],
    ['caption' => 'Настройка контактов', 'icon' => 'fa-user', 'url' => '/admin/profile'],
    ['caption' => 'Портфолио', 'icon' => 'fa-file-archive-o', 'url' => '/admin/catalogs'],
];

if(SYS::$isAuth && SYS::$authUser->role == Users::ROLE_ADMIN)
    $menu[] = ['caption' => 'Пользователи', 'icon' => 'fa-users', 'url' => '/admin/users'];
$menu[] = ['caption' => 'Выход', 'icon' => 'fa-sign-out', 'url' => '/admin/logout'];

return $menu;