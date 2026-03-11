<?php

namespace Controller\Admin;

use lib\SYS;

class ProfileController extends BaseAdminController {
    
    function index(){
        SYS::view('admin/profile', [
            'caption' => 'Настройка профиля',
        ]);
    }

    // POST

    function save(){
        unset(SYS::$session['error']);

        // проверка на то, что пользователь хочет поменять свой пароль
        if(isset($_POST['pass']) && trim($_POST['pass'])){
            if(trim($_POST['pass']) != trim($_POST['pass_two'] ?? '')){
                SYS::$session['error'] = 'Несовпадают введеные пароли';
                SYS::back();
            }
            $this->user->password = $_POST['pass'];
        }

        if(isset($_POST['login']) && !trim($_POST['login'])){
            SYS::$session['error'] = 'Недопустимо вводить пустой логин';
            SYS::back();
        }

        $fileds = ['login', 'fio', 'tel', 'email', 'telegram', 'desc'];
        foreach($fileds as $filed)
            $this->user->{$filed} = $_POST[$filed];

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
            $fileName = $this->user->id.'_'.basename($_FILES['avatar']['name']);
            move_uploaded_file($_FILES['avatar']['tmp_name'], 'public/storage/avatars/'.$fileName);
            $this->user->avatar = $fileName;
        }

        if(!$this->user->save())
            SYS::$session['error'] = 'Неудалось сохранить пользователя';

        SYS::back();
    }
}