<?php
chdir('..');
include_once 'lib/session.php';
include_once 'lib/utils.php';
include_once 'DATA/users.php';

AutoAuth(true); // если нет пользователя, вернемся назад

if(hasLoadCorrectFileImage('photo')) {
    $fileName = 'img/photos_'.$user['id'].'/'.basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $fileName);
}

toBack();