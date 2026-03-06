<?php

namespace lib;

interface ISession extends \ArrayAccess {
    function Init();
    function reStart();
    function ID(): string;
    function Set(string $name, $value = null);
    function Get(string $name): mixed;
    function __get($name);
    function __set($name, $value);
    function __unset($name);
    function __isset($name);
}
