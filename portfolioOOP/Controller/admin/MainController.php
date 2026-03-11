<?php

namespace Controller\Admin;

use lib\SYS;

class MainController extends BaseAdminController {
    function index(){
        SYS::view('admin/main', [
            'caption' => 'Панель администратора'
        ]);
    }
}