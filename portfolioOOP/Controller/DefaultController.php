<?php
namespace Controller;

use lib\SYS;

class DefaultController extends BaseController {
    function index(){
        SYS::view('default', [
            'caption' => 'Сайт для вашего портфолио'
        ]);
    }

    function page404(){
        SYS::view('404', [
            'caption' => '404'
        ]);
    }
}