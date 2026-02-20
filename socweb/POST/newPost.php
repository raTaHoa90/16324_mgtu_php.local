<?php
chdir('..');
include_once 'lib/session.php';
include_once 'lib/utils.php';
include_once 'DATA/users.php';
include_once 'DATA/posts.php';

AutoAuth(true); // если нет пользователя, вернемся назад

if(hasLoadCorrectFileImage('postImage')) {
    $path = 'img/posts_'.$user['id'];
    $fileName = $path.'/'.basename($_FILES['postImage']['name']);
    if(!is_dir($path))
        mkdir($path);
    move_uploaded_file($_FILES['postImage']['tmp_name'], $fileName);
} else 
    $fileName = "";


savePostData($user['id'], $fileName, $_POST['msg'] ?? '');

toBack();