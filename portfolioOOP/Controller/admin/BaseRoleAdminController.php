<?php

namespace Controller\Admin;

use DATA\Users;
use lib\SYS;

class BaseRoleAdminController extends BaseAdminController {
    function __construct($name) {
        parent::__construct($name);
        if($this->user->role != Users::ROLE_ADMIN)
            SYS::redirect('/admin');
    }
}