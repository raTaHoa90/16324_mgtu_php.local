<?php
$users = include "DATA/users.php";

$userNum = -1; 
foreach($users as $num => $user)
    if($user['login'] === $_POST['login']){
        $userNum = $num;
        break;
    }

if($userNum == -1){
    header('Location: '.$_SERVER['HTTP_REFERER'] . 
        (strpos($_SERVER['HTTP_REFERER'], '?') === false ? '?' : '&' )
        .'error=Пользователь не существует'
    );
    exit;
}

if($users[$userNum]['password'] != $_POST['pass']){
    header('Location: '.$_SERVER['HTTP_REFERER'] . 
        (strpos($_SERVER['HTTP_REFERER'], '?') === false ? '?' : '&' )
        .'error=Не верно указан логин или пароль'
    );
    exit;
}

/*
$time = time() + 60*60;
$date = date('r', $time);
header('Set-Cookie: hasAuth=1; Experies='.$date, false);
*/

$time = time() + 60*60; // - автоматически выбросить пользователя через час
setcookie('hasAuth','1', $time); 
//setcookie('hasAuth', '1', 0); //- для хранении куки-переменной, пока пользователь не закроет браузер
//setcookie('hasAuth', '1', 1); //- для удаления куки-переменной

setcookie('UID', $users[$userNum]['id'], $time);
header('Location: '.$_SERVER['HTTP_REFERER']);