<?php

namespace Controller\Admin;

use lib\SYS;

class RegistrationController extends BaseAuthController {
        
    function index(){
        SYS::view('admin/registration', [ 
            'caption' => 'Регистрация',
        ]);
    }

    // POST 

    function registers(){
        if(isset($_POST['pass']) && $_POST['pass'] && 
            $_POST['pass'] != ($_POST['pass_two'] ?? '')
        ) {
            SYS::$session['error'] = 'Несовпадают введенные пароли';
            SYS::back();
        }

        if(isset($_POST['login']) && !$_POST['login']){
            SYS::$session['error'] = 'Недопустимо вводить пустой логин';
            SYS::back();
        }

        $user = [
            'password' => $_POST['pass'],
            'login' => $_POST['login']
        ];

        if(!createUserData($user))
            SYS::$session['error'] = 'Неудалось создать пользователя';

        SYS::redirect('/admin/auth');
    }
}