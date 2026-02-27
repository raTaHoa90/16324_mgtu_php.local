<?php

function GET_auth(){
    $data = [ 'caption' => 'Авторизация' ];

    if(isset($_SESSION['error']))
        $data['error'] = $_SESSION['error'];

    view('admin/auth', $data);
}

function POST_auth(){
    
    if(isset($_SESSION['error']))
        unset($_SESSION['error']);

    $user = getUserByLogin($_POST['login']);

    if($user === null){
        $_SESSION['error'] = 'Пользователь несуществует';
        redirect('/admin/auth');
    }

    if($user['password'] != $_POST['pass']){
        $_SESSION['error'] = 'Не верно указан логин или пароль';
        redirect('/admin/auth');
    }

    $_SESSION['hasAuth'] = true;
    $_SESSION['UID'] = $user['id'];
    redirect('/admin');
}

function GET_logout(){
    reStartSession();
    redirect('/admin/auth');
}