<?php

namespace Controller;

use DATA\Users;
use lib\SYS;

class UsersController extends BaseController {
    function getCatalogs($path, $pathGET){
        if(!is_dir($path))
            mkdir($path);

        $topCatalog = true;
        if(isset($pathGET) && $pathGET){
            $path .= '/'.$pathGET;
            $topCatalog = false;
        }

        $path = strtr($path, ['..'=>'', '//' => '/']);

        if(!is_dir($path))
            return false;

        $result = [];
        $dir = dir($path);
        while(false !== ($name = $dir->read()))
            if($name != '.' && (!$topCatalog || $name != '..')){
                $fullPath = $path.'/'.$name;
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
        
        return $result;
    }

    //=================================================
    // GET
    //=================================================

    function table(){
        SYS::view('users/table', [
            'caption' => 'Все пользователи',
            'users' => Users::all()
        ]);
    }

    function user($params){
        $user = Users::getUserByLogin($params['login']);
        
        if($user === null)
            SYS::redirect('/users');

        $currentPath = ($_GET['path'] ?? '');
        $currentPath = strtr($currentPath, ['..'=>'']);
        $currentPath = strtr($currentPath, ['//' => '/', '\\\\'=>'\\']);
        if($currentPath == '/' || $currentPath == '\\')
            $currentPath = '';

        $catalog = $this->getCatalogs($user->pathPublic(), $currentPath);

        if($catalog === false)
            SYS::redirect('/users/'.$user->login);

        if($currentPath){
            $topPath = pathinfo($currentPath, PATHINFO_DIRNAME);
            if($topPath ='/' || $topPath == '\\')
                $topPath = '';
        } else
            $topPath = '';

        SYS::view('users/simple', [
            'caption' => 'Профиль: '. ($user->getName() ),
            'user' => $user,
            'catalogs' => $catalog,
            'userpath' => '/storage/'.$user->id.'_catalog/'. $currentPath.'/',
            'currentPath' => $currentPath,
            'topPath' => $topPath,
            'EXT_PIC' => ['png','jpg','jpeg','gif','webp','ico'],
            'EXT_DOC' => ['doc','docx','odt','pdf','xml']
        ]);
    }
}