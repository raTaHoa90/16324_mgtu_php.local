<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class BaseAdminController {
    public ?Users $user;
    function __construct($name)
    {
        SYS::$shared['menu'] = include_once 'menu/admin.php';
        $this->user = SYS::AutoAuth();
        if($this->user === null){
            if(SYS::$routes->hasPost())
                $this->ajax_error('Нет доступа');
            else
                SYS::redirect('/admin/auth');
        }

        SYS::$shared['user'] = $this->user;
    }

    function ajax_error(string $msg){
        echo json_encode(['error'=>$msg]);
        exit;
    }
}