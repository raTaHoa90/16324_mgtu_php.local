<?php

$routes = config('routes',[]);
$hasDefaultPath = false;
$_tempParams;

function redirect($url){
    header('Location: '.$url);
    exit;
}

function toBack(){
    redirect($_SERVER['HTTP_REFERER']);
}

function page404(){
    http_response_code(404);
    include 'controllers/404.php';
    exit;
}

function routeFind(array $pathes, array $routes){
    global $hasDefaultPath, $_tempParams;

    if(count($pathes) == 0 || (count($pathes) == 1 && $pathes[0] == '')){
        // если у нас закончился введеный пользователем путь, 
        // то проверяем наличие ключа по умолчанию, и если он есть,
        // то возвращаем его настройку

        if(isset($routes['<<default>>'])){
            $hasDefaultPath = true;
            return $routes['<<default>>'];
        }

        return '404';
    }

    $path = array_shift($pathes);
    // проверяем наличие ключа пути
    if(isset($routes[$path])) {
        // у нас есть вложенные пути по этому ключу, входим на новую инетацию
        if(is_array($routes[$path]))
            return routeFind($pathes, $routes[$path]);

        // если мы достигли конечной настройки, в ключе будет имя скрипта, 
        // который необходимо запустить
        if(count($pathes) == 0)
            return $routes[$path];
    } else {
        $varUrl = array_find(array_keys($routes), fn($value)=>strlen($value) > 1 && $value[0] == '@');
        if($varUrl){
            $_tempParams[substr($varUrl, 1)] = $path;

            // у нас есть вложенные пути по этому ключу, входим на новую инетацию
            if(is_array($routes[$varUrl]))
                return routeFind($pathes, $routes[$varUrl]);
            
            // если мы достигли конечной настройки, в ключе будет имя скрипта, который необходимо запустить
            if(count($pathes) == 0)
                return $routes[$varUrl];
        }
    }

    return '404';
}

function routeGetScript(){
    global $routes, $hasDefaultPath, $_tempParams;

    // убираем из пути GET-переменные ("/dir1/dir2/dir3?key1=1&key2=2" => "/dir1/dir2/dir3")
    $path = explode('?', $_SERVER['REQUEST_URI'])[0];
    
    // разбиваем путь адреса на части ("/dir1/dir2/dir3" => ['','dir1','dir2','dir3'])
    $pathes = explode('/', $path);
    array_shift($pathes); // => ['dir1','dir2','dir3']

    // получаем метод запроса
    $method = $_SERVER['REQUEST_METHOD'];

    // проверяем его наличие в настройках
    if(isset($routes[$method])){
        // проходим по настройкам до указания скрипта, который необходимо выполнить
        $result = routeFind($pathes, $routes[$method]);
        if($result == '404')
            page404();

        $controller = config('app.paths.conrollers', 'controllers') . '/'. $result;

        // проверяем, что у нас есть файл контроллера
        if(file_exists($controller))
            include $controller;
        else
            page404();

        // определяем метод, который необходимо вызвать из этого скрипта
        if($hasDefaultPath)
            $nameFunc = 'default';
        else 
            $nameFunc = array_pop($pathes);

        $func = $method . '_' . $nameFunc;

        if(function_exists($func))
            // вызываем метод
            $func($_tempParams);
        else 
            page404();
    } else
        page404();
}