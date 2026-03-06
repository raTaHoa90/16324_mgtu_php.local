<?php

use lib\Routes;
use lib\SYS;

Routes::default('DefaultController@page404');

Routes::get('/admin', 'Admin/MainController');
Routes::get('/admin/auth','Admin/AuthController@auth');
Routes::get('/admin/registration', 'Admin/RegistrationController');

Routes::post('/admin/auth', 'Admin/AuthController@login');
Routes::post('/admin/registration', 'Admin/RegistrationController@registers');

if(SYS::$isAuth){
    Routes::get('/admin/logout', 'Admin/AuthController@logout');
    Routes::get('/admin/profile', 'Admin/ProfileController');
    Routes::get('/admin/catalogs', 'Admin/CatalogsController');

    Routes::post('/admin/profile', 'Admin/ProfileController@save');
    Routes::post('/admin/catalogs/getCatalogs', 'Admin/CatalogsController@getCatalogs');
    Routes::post('/admin/catalogs/createDir', 'Admin/CatalogsController@createDir');
    Routes::post('/admin/catalogs/uploadFile', 'Admin/CatalogsController@uploadFile');
    Routes::post('/admin/catalogs/deleteDir', 'Admin/CatalogsController@deleteDir');
    Routes::post('/admin/catalogs/deleteFile', 'Admin/CatalogsController@deleteFile');
}

Routes::get('/','DefaultController');
Routes::get('/users', 'UsersController@table');
Routes::get('/users/@login', 'UsersController@user');