<?php

namespace Controller\Admin;

use lib\SYS;

class CatalogsController extends BaseAdminController {

    public string $path;

    function ajax_init_catalog(): bool {
        $this->path = $this->user->pathPublic();
        // создаем каталок пользоваетля, если его нет
        if(!is_dir($this->path))
            mkdir($this->path);

        $topCatalog = true;
        if(isset($_POST['path']) && $_POST['path']){
            $this->path .= '/'.$_POST['path'];
            $topCatalog = false;
        }

        return $topCatalog;
    }

    function delete_dir($path){
        if(is_dir($path)){
            $entries = scandir($path);
            foreach($entries as $entry)
                if($entry != '.' && $entry != '..'){
                    $fullPath = $path . '/' .  $entry;
                    if(filetype($fullPath) == 'dir')
                        $this->delete_dir($fullPath);
                    else
                        unlink($fullPath);
                }
            rmdir($path);
        }
    }

    //=================================================
    // GET
    //=================================================

    function index() {
        SYS::view('admin/catalogs', [
            'caption' => 'Портфолио: '.($this->user->fio ?? $this->user->login),
        ]);
    }

    //=================================================
    // POST, AJAX
    //=================================================

    function getCatalogs(){
        $topCatalog = $this->ajax_init_catalog();

        if(!is_dir($this->path)){
            echo json_encode([]);
            exit;
        }

        $result = [];
        $dir = dir($this->path);
        while(false !== ($name = $dir->read()))
            if($name != '.' && (!$topCatalog || $name != '..')){
                $fullPath = $this->path.'/'.$name;
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

    function createDir(){
        $this->ajax_init_catalog();

        $fullpath = $this->path.'/'.($_POST['dirname'] ?? '');
        if(is_dir($fullpath))
            $this->ajax_error('такой каталог уже существует');

        mkdir($fullpath);

        echo json_encode(['ok'=>true]);
    }

    function uploadFile(){
        $this->ajax_init_catalog();
        if(!isset($_FILES['upFile']))
            $this->ajax_error('Нет файлов для загрузки');

        if(!is_dir($this->path))
            $this->ajax_error('Такого каталога не существует');

        $result = [];
        foreach($_FILES['upFile']['error'] as $i => $error)
            if($error == 0){
                $name = basename($_FILES['upFile']['name'][$i]);
                $fullPath = $this->path.'/'.$name;
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

    function deleteDir(){
        $this->ajax_init_catalog();

        $fullpath = $this->path . '/' . ($_POST['dirname'] ?? '');
        if(!is_dir($fullpath))
            $this->ajax_error('такой каталог отсутствует');

        $this->delete_dir($fullpath);

        echo json_encode(['ok'=>true]);
    }

    function deleteFile(){
        $this->ajax_init_catalog();

        $fullpath = $this->path . '/' . ($_POST['filename'] ?? '');
        if(!file_exists($fullpath))
            $this->ajax_error('такой файл отсутствует');

        unlink($fullpath);

        echo json_encode(['ok'=>true]);
    }
}