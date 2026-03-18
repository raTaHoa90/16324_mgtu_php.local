<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class UsersController extends BaseRoleAdminController {

    function index(){
        SYS::view('admin/users/table', [
            'caption' => 'Пользователи системы',
            'users' => Users::all()
        ]);
    }
}