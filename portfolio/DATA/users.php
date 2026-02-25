<?php
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

const CONTINUE_ARRAY = ['.', '..'];

// функция поиска пользователя по его ID, возвращает данные пользователя или Null
function getUserById(int $id): ?array {
    $users = loadModel('users');
    $num = getIndexUserById($id);
    return $num < 0 ? null : $users[$num];
}

// функция поиска пользователя по его Login, возвращает данные пользователя или Null
function getUserByLogin(string $login): ?array {
    $users = loadModel('users');
    $num = getIndexUserByLogin($login);
    return $num < 0 ? null : $users[$num];
}

// функция поиска пользователя по его ID, возвращает индекс пользователя в массиве всех пользователей
function getIndexUserByLogin(string $login): int {
    $users = loadModel('users');
    foreach($users as $num => $user)
        if($user['login'] == $login)
            return $num;

    return -1;
}

// функция поиска пользователя по его Login, возвращает индекс пользователя в массиве всех пользователей
function getIndexUserById(int $id): int {
    $users = loadModel('users');
    foreach($users as $num => $user)
        if($user['id'] == $id)
            return $num;

    return -1;
}

function saveUserData(int $id, array $data): bool {
    $users = loadModel('users');
    $numUser = getIndexUserById($id);

    // если не нашли пользователя, ничего не делаем
    if($numUser < 0)
        return false;

    $users[$numUser] = array_merge($users[$numUser], $data);
    // сохраняем обновленные данные в файл, для восстановления их при новом запросе
    file_put_contents('DATA/users.json', json_encode($users));
    return true;
}

function getAllPhotos(){
    $user = AutoAuth();
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