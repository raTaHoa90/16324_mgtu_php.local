<?php

function redirect($url){
    header('Location: '.$url);
    exit;
}

function toBack(){
    redirect($_SERVER['HTTP_REFERER']);
}