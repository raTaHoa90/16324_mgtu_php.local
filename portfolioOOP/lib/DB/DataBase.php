<?php

namespace lib\DB;

abstract class DataBase {
    const 
        TYPE_OBJECT = true,
        TYPE_ASSOC = false;

    static $debug = true;
    private $_debug_list = [];

    abstract function connect(string $hostname, string $database, string $username, ?string $password = null, int $port = 0);
    abstract function disconnect();
    abstract function query(string $sql, ?array $params): bool;
    abstract function queryClose(string $sql, ?array $params): int;
    abstract function rowsCount(): int;
    abstract function affectRows(): int;
    abstract function countFields(): int;
    abstract function getFields(): array;
    abstract function getNameFields(): array;
    abstract function resultAll(bool $typeResult = self::TYPE_OBJECT, ?string $className = null, array $args = []): array;
    abstract function esc_db(mixed $value, string $temp);
    
    abstract function limit(int $offset, int $limit): string;
    abstract function insertGetId(string $sql, ?array $params): int;

    abstract function debugAddError();

    function __construct(string $hostname, string $database, $username, ?string $password = null, int $port = 0) {
        $this->connect($hostname, $database, $username, $password, $port);
    }

    function __destruct() {
        $this->disconnect();
    }

    function debugLog(string $msg, string $group = "SQL"){
        $this->_debug_list[] = date_format(date_create(), 'd/m/Y H:i:s.u # ')."[$group]: $msg";
    }

    function getDebug(string $sep = '<br>'): string {
        return implode($sep, $this->_debug_list);
    }

    function page(int $limit, int $page): string {
        return $this->limit(($page - 1) * $limit, $limit);
    }

    function esc(mixed $value){
        if( is_null($value) )     $value = 'NULL';
        elseif($value === false)  $value = 'FALSE';
        elseif($value === true)   $value = 'TRUE';
        elseif(
            is_numeric($value) &&
            is_string($value) &&
            strlen($value) > 1 &&
            strpos($value, '.')=== false &&
            $value[0] == '0'
        ) $value = "'$value'";
        elseif(!is_numeric($value)){
            $value = stripslashes($value);
            $temp = strlen($value) < 16 ? strtoupper($value) : $value;
            $value = $this->esc_db($value, $temp);
        }
        return $value;
    }

    function table(string $sql, ?array $params = null, bool $typeResult = self::TYPE_OBJECT, ?string $className = null, array $args = []){
        if($this->query($sql, $params)){
            $num_rows = $this->rowsCount();
            if(static::$debug)
                $this->debugLog("count rows $num_rows", 'SELECT');
            if($num_rows <= 0)
                return [];
            
            return $this->resultAll($typeResult, $className, $args);
        } else {
            if(static::$debug)
                $this->debugAddError();
            return [];
        }
    }

}