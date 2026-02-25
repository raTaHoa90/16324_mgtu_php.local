<?php

function loadPage($path, $pages = []){
    $content = file_get_contents(config('app.paths.templates','views') . "/$path.php");
    // заменяем все вставки {{VAR}} на те что уже были
    if(count($pages))
        $content = strtr($content, $pages);

    // разбиваем файл шаблона на строки
    $lines = explode(PHP_EOL, $content);
    // забираем первую линию и сразу делим ее по пробелам на параметры
    $line = explode(' ', array_shift($lines));
    // если это не самый верхний шаблон, но рекурсивно подгружаем шаблон в который надо вставить текущий,
    // до тех пор, пока не выйдем на самый верх
    if($line[0] == '@extend'){
        $pages['{{'.$line[1].'}}'] = implode(PHP_EOL, $lines);
        return loadPage($line[2], $pages);
    }
    return $content;
}

function view($page, $vars = []){
    $page = loadPage($page);

    $name = 'temp_'.date('Y_m_d_h_i_s').rand(100000000, 999999999);
    $path = config('app.paths.temp', 'temp')."/$name.php";
    file_put_contents($path, $page);

    extract($vars);
    /*
        $vars = ['key1' => 123, 'key2' => 'test'];
        =>
        $key1 = 123;
        $key2 = 'test';
    */

    include $path;
    unlink($path);
}