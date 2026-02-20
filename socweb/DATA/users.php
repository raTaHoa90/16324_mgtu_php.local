<?php
// загружаем содержимое файлф в переменную
$file = file_get_contents('DATA/users.json');
// парсим JSON-форман, что бы работать с данными как с массивом PHP
$users = json_decode($file, true);

$isAuth = false;
$user = null;

const CONTINUE_ARRAY = ['.', '..'];

/*
    id:
    login:
    password:
    avatar: 
    fio:
    city:
    job:
    tel:
    age:
*/

// функция поиска пользователя по его ID, возвращает данные пользователя или Null
function getUserById(int $id): ?array {
    global $users;
    $num = getIndexUserById($id);
    return $num < 0 ? null : $users[$num];
}

// функция поиска пользователя по его Login, возвращает данные пользователя или Null
function getUserByLogin(string $login): ?array {
    global $users;
    $num = getIndexUserByLogin($login);
    return $num < 0 ? null : $users[$num];
}

// функция поиска пользователя по его ID, возвращает индекс пользователя в массиве всех пользователей
function getIndexUserByLogin(string $login): int {
    global $users;
    foreach($users as $num => $user)
        if($user['login'] == $login)
            return $num;

    return -1;
}

// функция поиска пользователя по его Login, возвращает индекс пользователя в массиве всех пользователей
function getIndexUserById(int $id): int {
    global $users;
    foreach($users as $num => $user)
        if($user['id'] == $id)
            return $num;

    return -1;
}

function saveUserData(int $id, array $data): bool {
    global $users;
    $numUser = getIndexUserById($id);

    // если не нашли пользователя, ничего не делаем
    if($numUser < 0)
        return false;

    $users[$numUser] = array_merge($users[$numUser], $data);
    // сохраняем обновленные данные в файл, для восстановления их при новом запросе
    file_put_contents('DATA/users.json', json_encode($users));
    return true;
}

function AutoAuth(bool $isToBack = false){
    global $isAuth, $user;
    $isAuth = isset($_SESSION['hasAuth']);
    $user = $isAuth ? getUserById($_SESSION['UID']) : null;

    if($isToBack && !$user)
        toBack();
}

function getAllPhotos(){
    global $user;
    $path = 'img/photos_'.$user['id'];
    
    $result = [];
    if(!is_dir($path))
        return $result;

    $catalog = dir($path);
    while(false !== ($entry = $catalog->read())){
        //echo $entry.'<br>';
        if(!in_array($entry, CONTINUE_ARRAY) && !is_dir('img/'.$entry)) 
            $result[] = $entry;
    }

    return $result;
}