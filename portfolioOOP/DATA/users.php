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
    role:
*/

namespace DATA;

use lib\SYS;

class Users extends Model {
    const 
        CONTINUE_ARRAY = ['.', '..'],
        FILE_NAME = 'users',
        
        ROLE_DEFAULT = 0,
        ROLE_ADMIN = 1,

        ROLES = [
            self::ROLE_DEFAULT => 'Пользоваетль',
            self::ROLE_ADMIN => 'Администратор'
        ];


    static function all(): array{
        $users = SYS::loadModel(static::FILE_NAME);
        return array_map(fn($user)=>new static($user), $users);
    }

    // функция поиска пользователя по его ID, возвращает данные пользователя или Null
    static function getUserById(int $id): ?Users {
        $users = SYS::loadModel(static::FILE_NAME);
        $num = static::getIndexUserById($id);
        return $num < 0 ? null : new static($users[$num]);
    }

    // функция поиска пользователя по его Login, возвращает данные пользователя или Null
    static function getUserByLogin(string $login): ?Users {
        $users = SYS::loadModel(static::FILE_NAME);
        $num = static::getIndexUserByLogin($login);
        return $num < 0 ? null : new static($users[$num]);
    }

    // функция поиска пользователя по его ID, возвращает индекс пользователя в массиве всех пользователей
    static function getIndexUserByLogin(string $login): int {
        $users = SYS::loadModel(static::FILE_NAME);
        foreach($users as $num => $user)
            if($user['login'] == $login)
                return $num;

        return -1;
    }

    // функция поиска пользователя по его Login, возвращает индекс пользователя в массиве всех пользователей
    static function getIndexUserById(int $id): int {
        $users = SYS::loadModel(static::FILE_NAME);
        foreach($users as $num => $user)
            if($user['id'] == $id)
                return $num;

        return -1;
    }

    static function create(array $data): Users{
        $users = SYS::loadModel(static::FILE_NAME);

        $max = array_reduce($users, fn($max, $user)=> max($max, $user['id']), 0);
        $max++;

        $data['id'] = $max;
        $users[] = $data;
        file_put_contents(config('app.paths.models').'/'.static::FILE_NAME.'.json', json_encode($users));
        return new static($data);
    }

    //==============================================================

    function save(): bool {
        $users = SYS::loadModel(static::FILE_NAME);
        $numUser = static::getIndexUserById($this->id);

        // если не нашли пользователя, ничего не делаем
        if($numUser < 0)
            return false;

        $users[$numUser] = $this->getData();
        // сохраняем обновленные данные в файл, для восстановления их при новом запросе
        file_put_contents('DATA/'.static::FILE_NAME.'.json', json_encode($users));
        return true;
    }

    function getAllPhotos(): array {
        $path = 'img/photos_'.$this->id;
        
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

    function pathPublic(): string {
        return 'public/storage/'.$this->id.'_catalog';
    }

    function getDesc(): string{
        return strtr($this->desc ?? '', ["\n" => '<br>']);
    }

    function roleCaption(): string{
        return static::ROLES[$this->role ?? static::ROLE_DEFAULT];
    }

    function getName(): string {
        return $this->fio ?: $this->login ?: $this->email;
    }
}