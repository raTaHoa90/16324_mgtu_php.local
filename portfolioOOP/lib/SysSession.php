<?php

namespace lib;

final class SysSession implements ISession {
    function __construct() {
        $this->Init();
    }
    
    function Init(){
        session_name(config('session.name', 'MGTU_SES'));
        $timeout = config('session.timeout', 60 * 60);
        $age = time() + $timeout;
        ini_set('session.cookie_lifetime', $age);
        session_set_cookie_params($timeout);
        session_cache_expire($age);

        if(isset($_COOKIE[session_name()]))
            setcookie(session_name(), $_COOKIE[session_name()], $age, '/');

        session_start();
    }

    function reStart(){
        session_unset();   // уничтожить все переменные сессии
        session_destroy(); // уничтожить файл сессии
        //session_regenerate_id(true);
    }

    function ID(): string{
        return session_id();
    }

    function Set(string $name, $value = null){
        if($value === null)
            unset($_SESSION[$name]);
        else
            $_SESSION[$name] = $value;
    }

    function Get(string $name): mixed {
        return $_SESSION[$name] ?? null;
    }

    // magic methods
    function __get($name) {
        return $this->Get($name);
    }

    function __set($name, $value){
        $this->Set($name, $value);
    }

    function __unset($name) {
        $this->Set($name);
    }

    function __isset($name){
        return isset($_SESSION[$name]);
    }

    // interface ArrayAccess
    function offsetExists(mixed $offset): bool {
        return isset($_SESSION[$offset]);
    }

    function offsetGet(mixed $offset): mixed {
        return $this->Get($offset);
    }

    function offsetSet(mixed $offset, mixed $value): void {
        $this->Set($offset, $value);
    }

    function offsetUnset(mixed $offset): void {
        $this->Set($offset);
    }
}