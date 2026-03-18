<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class MainController extends BaseAdminController {
    function addUrlSiteMap($file, string $url, string $date){
        $url = config('app.domain').$url;
        fwrite($file, <<<TAGURL
        <url>
            <loc>$url</loc>
            <lastmod>$date</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        TAGURL);
    }

    function UserReadCatalogForSiteMap($fileSiteMap, string $path, string $basePath, string $publicPath){
        if(!is_dir($basePath.$path)) return;

        $catalog = scandir($basePath.$path);
        foreach($catalog as $cPath)
            if($cPath != '.' && $cPath != '..'){
                $fName = $basePath.$path.'/'.$cPath;
                $pName = $publicPath.$path.'/'.$cPath;
                /*if(file_exists($fName))
                    $this->addUrlSiteMap($fileSiteMap, $pName, date('Y-m-d',fileatime($fName)));
                else*/
                if(is_dir($fName)) {
                    $this->addUrlSiteMap($fileSiteMap, $pName, date('Y-m-d'));
                    $this->UserReadCatalogForSiteMap($fileSiteMap, $path.'/'.$cPath, $basePath, $publicPath);
                }
            }
    }
    
    //===================================

    function index(){
        SYS::view('admin/main', [
            'caption' => 'Панель администратора'
        ]);
    }

    function CreateSiteMap(){
        /*
        $fHandle = fopen('path', 'r' | 'wb' | 'w');
	
        while(($buffer = fgets($fHandle, $maxRead)) !== false) echo $buffer;
        
        fgets($f, $max) - построчное чтение файла
        fgetc($f) - считывает 1 символ из файла
        fread($f, $max) - чтение данных из файла, до $max длинны или меньше
        
        feof($f):bool  - проверяет не достигнут ли конец файла
        fseek($f, $offset) - позволяет сместить указатель в файле, на выбранную позицию, для дальнейшего чтения или записи
        
        fwrite($f, $strData, [$length]) - записать в файл данные
        
        fclose($fHandle);


        file_exists($filename) // проверяем, есть ли файл
        is_dir($filename)  // проверяем есть ли каталог
        is_file($filename) // проверяем, есть ли файл
        copy($from, $to)   // скопировать каталог или файл из FROM в TO
        unlink($filename) // для удаления файла
        
        mkdir($dirname [, $permishen = 0777, $recursive = false]) // создает каталог
        rmdir($dirname) // удаляет каталог
        rename($from, $to) // переименовывает файл или каталог
        
        pathinfo($file, PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME): string
        */
        $file = fopen('public/sitemap/dyn.xml', 'wb');
        
        fwrite($file, <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
XML);

        $users = Users::all();
        foreach($users as $user){
            /** @var Users $user */
            $this->UserReadCatalogForSiteMap($file, '', 
                $user->pathPublic(), 
                'users/'.$user->login.'?path='
            );
        }

        fwrite($file, '</urlset>');
        fclose($file);

        SYS::back();
    }
}