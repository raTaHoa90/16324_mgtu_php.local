<?php

namespace lib;

use DATA\Users;

class SYS {
    static bool $isAuth = false;
    static ?Users $authUser = null;
    static array $configs = [];
    static array $models = [];

    static ?ISession $session = null;
    static ?View $view = null;
    static ?Routes $routes = null;

    static $shared = [];

    static function Init(){
        static::$session = new SysSession;
        static::$view = new View;
        
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        if(config('session.is_auth', false))
            static::AutoAuth();

        static::$routes = new Routes;
        (static::$routes)();
    }

    static function AutoAuth(){
        if( static::$authUser === null){
            static::$isAuth = isset(static::$session['hasAuth']);
            static::$authUser = static::$isAuth ? Users::getUserById(static::$session['UID']) : null;
        }
        return static::$authUser;
    }

    static function loadModel($name){
        if(!isset(static::$models[$name])){
            include_once config('app.paths.models','models'). "/$name.php";
            $file = file_get_contents(config('app.paths.models','models'). "/$name.json");
            static::$models[$name] = json_decode($file, true);
        }
        return static::$models[$name];
    }

    static function view(string $page, array $args = []){
        static::$view->render($page, array_merge(static::$shared, $args));
    }

    static function redirect($url){
        static::$view->redirect($url);
    }

    static function back(){
        static::$view->toBack();
    }
}

spl_autoload_register(function($className){
    $loadPath = strtr($className, ['\\' =>'/']).'.php'; //"lib/$className.php";
    if(is_file($loadPath)){
        include_once $loadPath;
        if( !class_exists($className) &&
            !trait_exists($className) &&
            !interface_exists($className) &&
            !enum_exists($className)
        ) throw "Class $className not found";

        return;
    }
    throw "Class $className not found";
});

include_once 'lib/utilits.php';

//include_once 'lib/session.php';
//include_once 'lib/Routes.php';
//include_once 'lib/View.php';

//loadModel('users');