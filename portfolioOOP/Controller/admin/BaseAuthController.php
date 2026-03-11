<?php

namespace Controller\Admin;

use lib\SYS;

class BaseAuthController {
    function __construct($name)
    {
        SYS::$shared['menu'] = include_once 'menu/auth.php';

        if(isset(SYS::$session['error']))
            SYS::$shared['error'] = SYS::$session['error'];
    }
}