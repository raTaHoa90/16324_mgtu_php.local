<?php

function redirect($url){
    header('Location: '.$url);
    exit;
}

function toBack(){
    redirect($_SERVER['HTTP_REFERER']);
}

function hasLoadCorrectFileImage($name){
    return 
        isset($_FILES[$name]) &&
        $_FILES[$name]['error'] == 0 &&
        substr($_FILES[$name]['type'], 0, 6) == 'image/';
}