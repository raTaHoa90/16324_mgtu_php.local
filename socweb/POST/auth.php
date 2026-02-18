<?php
chdir('..');
include_once 'lib/session.php';
include_once 'lib/utils.php';
include_once 'DATA/users.php';

if(isset($_SESSION['error']))
    unset($_SESSION['error']);

$user = getUserByLogin($_POST['login']); 

if($user === null){
    $_SESSION['error'] = 'Пользователь не существует';
    toBack();
}

if($user['password'] != $_POST['pass']){
    $_SESSION['error'] = 'Не верно указан логин или пароль';
    toBack();
}

/*
$time = time() + 60*60;
$date = date('r', $time);
header('Set-Cookie: hasAuth=1; Experies='.$date, false);
*/

$_SESSION['hasAuth'] = true;
$_SESSION['UID'] = $user['id'];
toBack();

//$time = time() + 60*60; // - автоматически выбросить пользователя через час
//setcookie('hasAuth','1', $time); 
//setcookie('hasAuth', '1', 0); //- для хранении куки-переменной, пока пользователь не закроет браузер
//setcookie('hasAuth', '1', 1); //- для удаления куки-переменной

//setcookie('UID', $users[$userNum]['id'], $time);
//header('Location: '.$_SERVER['HTTP_REFERER']);