<?php

function GET_catalogs() {
    $menu = include 'menu/admin.php';
    $user = AutoAuth();
    if($user === null)
        redirect('/admin/auth');

    view('admin/catalogs', [
        'caption' => 'Портфолио: '.($user['fio'] ?? $user['login']),
        'menu' => $menu,
        'user' => $user
    ]);
}

function ajax_error(string $msg){
    echo json_encode(['error' => $msg]);
    exit;
}

function ajax_init_catalog(): array{
    $user = AutoAuth();
    if($user === null)
        ajax_error('Нет доступа');

    $path = 'public/storage/'.$user['id'].'_catalog';
    if(!is_dir($path))
        mkdir($path);

    $topCatalog = true;
    if(isset($_POST['path']) && $_POST['path']){
        $path .= '/'.$_POST['path'];
        $topCatalog = false;
    }

    return [
        'user' => $user,
        'topCatalog' => $topCatalog,
        'path' => $path
    ];
}

function getSizeFile(int &$size): string{
    $prefix = 'bytes';
    while ($size > 1024){
        $size = $size / 1024;
        $prefix = match($prefix){
            'bytes' => 'kb',
            'kb' => 'mb',
            'mb' => 'gb'
        };
    }
    return $prefix;
}

function POST_getCatalogs(){
    $dataPath = ajax_init_catalog();

    if(!is_dir($dataPath['path'])){
        echo json_encode([]);
        exit;
    }

    $result = [];
    $dir = dir($dataPath['path']);
    while(false !== ($name = $dir->read()))
        if($name != '.' && (!$dataPath['topCatalog'] || $name != '..')){
            $fullPath = $dataPath['path'].'/'.$name;
            $data = ['name' => $name];
            
            if(filetype($fullPath) != 'dir'){
                $size = filesize($fullPath);
                $prefix = getSizeFile($size);

                $data['size'] = ((int)$size).' '.$prefix;
                $data['ext'] = pathinfo($fullPath, PATHINFO_EXTENSION);
                $data['created_at'] = date('d.m.Y H:i', filectime($fullPath));
                $data['type'] = filetype($fullPath);
            } else
                $data['type'] = 'dir';

            $result[] = $data;
        }
    
    usort($result, function($a, $b){
        if($a['type'] == $b['type'])
            return $a['name'] <=> $b['name'];
        elseif($a['type'] == 'dir')
            return -1;
        else
            return 1;
    });
    
    echo json_encode($result);
}

function POST_createDir(){
    $data = ajax_init_catalog();

    $fullpath = $data['path'].'/'.($_POST['dirname'] ?? '');
    if(is_dir($fullpath))
        ajax_error('такой каталог уже существует');

    mkdir($fullpath);

    echo json_encode(['ok'=>true]);
}

function POST_uploadFile(){
    $data = ajax_init_catalog();
    if(!isset($_FILES['upFile']))
        ajax_error('Нет файлов для загрузки');

    if(!is_dir($data['path']))
        ajax_error('Такого каталога не существует');

    $result = [];
    foreach($_FILES['upFile']['error'] as $i => $error)
        if($error == 0){
            $name = basename($_FILES['upFile']['name'][$i]);
            $fullPath = $data['path'].'/'.$name;
            move_uploaded_file($_FILES['upFile']['tmp_name'][$i], $fullPath);

            $size = filesize($fullPath);
            $prefix = getSizeFile($size);

            $result[] = [
                'name' => $name,
                'size' => ((int)$size).' '.$prefix,
                'ext'  => pathinfo($fullPath, PATHINFO_EXTENSION),
                'created_at' => date('d.m.Y H:i', filectime($fullPath)),
                'type' => filetype($fullPath)
            ];
        }

    echo json_encode($result);
}

function delete_dir($path){
    if(is_dir($path)){
        $entries = scandir($path);
        foreach($entries as $entry)
            if($entry != '.' && $entry != '..'){
                $fullPath = $path . '/' .  $entry;
                if(filetype($fullPath) == 'dir')
                    delete_dir($fullPath);
                else
                    unlink($fullPath);
            }
        rmdir($path);
    }
}

function POST_deleteDir(){
    $data = ajax_init_catalog();

    $fullpath = $data['path'] . '/' . ($_POST['dirname'] ?? '');
    if(!is_dir($fullpath))
        ajax_error('такой каталог отсутствует');

    delete_dir($fullpath);

    echo json_encode(['ok'=>true]);
}

function POST_deleteFile(){
    $data = ajax_init_catalog();

    $fullpath = $data['path'] . '/' . ($_POST['filename'] ?? '');
    if(!file_exists($fullpath))
        ajax_error('такой файл отсутствует');

    unlink($fullpath);

    echo json_encode(['ok'=>true]);
}