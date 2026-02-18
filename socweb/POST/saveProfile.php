<?php
chdir('..');
include_once 'lib/session.php';
include_once 'lib/utils.php';
include_once 'DATA/users.php';


AutoAuth(true); // если нет пользователя, вернемся назад

unset($_SESSION['error']);


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

$user['login']= $_POST['login'];
$user['fio']  = $_POST['fio'];
$user['city'] = $_POST['city'];
$user['job']  = $_POST['job'];
$user['tel']  = $_POST['tel'];
$user['age']  = +$_POST['age'];

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
    move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/'.$fileName);
    $user['avatar'] = '/img/'.$fileName;
}

if(!saveUserData($user['id'], $user))
    $_SESSION['error'] = 'Неудалось сохранить пользователя';

toBack();