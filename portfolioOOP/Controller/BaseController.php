<?php 

namespace Controller;

use lib\SYS;

class BaseController {
    function __construct($name) {
        SYS::$shared['menu'] = include_once 'menu/main.php';
    }
}