<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class AuthController extends BaseAuthController {

    function auth(){
        SYS::view('admin/auth', [
            'caption' => 'Авторизация'
        ]);
    }

    function logout(){
        SYS::$session->reStart();
        SYS::redirect('/admin/auth');
    }

    // POST

    function login(){
        if(isset(SYS::$session['error']))
            unset(SYS::$session['error']);

        $user = Users::getUserByLogin($_POST['login']);
        
        if($user === null){
            SYS::$session['error'] = 'Пользователь несуществует';
            SYS::redirect('/admin/auth');
        }

        if($user->password != $_POST['pass']){
            SYS::$session['error'] = 'Не верно указан логин или пароль';
            SYS::redirect('/admin/auth');
        }

        SYS::$session['hasAuth'] = true;
        SYS::$session['UID'] = $user->id;
        SYS::redirect('/admin');
    }
}