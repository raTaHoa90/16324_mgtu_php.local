<?php

namespace Controller\Admin;

use DATA\Users;
use lib\MailAgent;
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

        if(isset($_POST['email']) && !$_POST['email'] && 
            !SYS::emailValidation($_POST['email'])
        ){
            SYS::$session['error'] = 'Неправильно введен Email';
            SYS::back();
        }

        $login = trim($_POST['login']);
        $password = $_POST['pass'];

        $user = Users::create([
            'password' => $password,
            'login' => $login,
            'email' => $_POST['email']
        ]);
        /** @var Users $users */

        if($user){
            $user->setPassword($password)->save();

            $mail = new MailAgent;
            $mail->addAddress($user->email);
            $mail->setMessage('Вы зарегестрировались на сайте Портфолио', <<<ENDMESSAGE
                <!DOCTYPE html>
                <html>
                    <head></head>
                    <body>
                        Вы зарегистрировались на нашем сайте портфолио!<br>
                        ваш логин: <b>$login</b><br>
                        пароль: <b>$password</b><br><br>
                        Добро пошаловать!!!
                    </body>
                </html>
            ENDMESSAGE);
            $mail->send();
        } else
            SYS::$session['error'] = 'Неудалось создать пользователя'; 

        SYS::redirect('/admin/auth');
    }
}