<?php

function GET_profile(){
    $menu = include 'menu/admin.php';
    $user = AutoAuth();
    if($user === null)
        redirect('/admin/auth');

    view('admin/profile', [
        'caption' => 'Настройка профиля',
        'menu' => $menu,
        'user' => $user
    ]);
}

function POST_profile(){
    unset($_SESSION['error']);
    $user = AutoAuth();
    if($user === null)
        redirect('/admin/auth');

    // проверка на то, что пользователь хочет поменять свой пароль
    if(isset($_POST['pass']) && trim($_POST['pass'])){
        if(trim($_POST['pass']) != trim($_POST['pass_two'] ?? '')){
            $_SESSION['error'] = 'Несовпадают введеные пароли';
            toBack();
        }
        $user['password'] = $_POST['pass'];
    }

    if(isset($_POST['login']) && !trim($_POST['login'])){
        $_SESSION['error'] = 'Недопустимо вводить пустой логин';
        toBack();
    }

    $fileds = ['login', 'fio', 'tel', 'email', 'telegram', 'desc'];
    foreach($fileds as $filed)
        $user[$filed] = $_POST[$filed];

    /*
        $_FILES['document'] = [
            'name' = имя передаваемого файла,
            'type' = MIME-type файла (пример: "image/png")
            'size' = размер файла в байтах
            'tmp_name' = путь к временному размещению файла
            'error' = код ошибки, которая возникла при получении файла
            'full_path' = полный путь к файлу, который расположен на машине пользователя
        ];
    */

    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){
        $fileName = $user['id'].'_'.basename($_FILES['avatar']['name']);
        move_uploaded_file($_FILES['avatar']['tmp_name'], 'public/storage/avatars/'.$fileName);
        $user['avatar'] = $fileName;
    }

    if(!saveUserData($user['id'], $user))
        $_SESSION['error'] = 'Неудалось сохранить пользователя';

    toBack();
}