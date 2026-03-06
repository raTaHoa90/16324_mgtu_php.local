<?php

use lib\SYS;

// app.paths.templates
function config(string $name, $defaultValue = null){
    $keys = explode('.', $name); // => ['app', 'paths', 'templates']
    $fileName = array_shift($keys); // => filename = 'app', $keys = ['paths', 'templates']
    $path = "./configs/$fileName.php";

    // проверяем существует ли файл конфигурации
    if(!file_exists($path))
        return $defaultValue;

    // проверяем загружали ли мы его уже или нет
    if(isset(SYS::$configs[$fileName]))
        $configs = SYS::$configs[$fileName];
    else {
        $configs = include_once $path;
        SYS::$configs[$fileName] = $configs;
    }

    // бежим по вложенностям, пока не достигнем предела вложенностей 
    // или пока не найдем нужный ключ
    while($configs !== null && count($keys) > 0){
        $key = array_shift($keys);
        $configs = $configs[$key] ?? null;
    }

    return $configs ?? $defaultValue;
}