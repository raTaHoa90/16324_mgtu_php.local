<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class UsersController extends BaseAdminController {

    function __construct($name) {
        parent::__construct($name);
        if($this->user->role != Users::ROLE_ADMIN)
            SYS::redirect('/admin');
    }

    function index(){
        SYS::view('admin/users/table', [
            'caption' => 'Пользователи системы',
            'users' => Users::all()
        ]);
    }
}