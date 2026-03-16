<?php

namespace lib\DB;

final class DBMySqlDriver extends DataBase {
    const VALUE_NO_STRING = [
        'NULL', 'NOT NULL', 'TRUE', 'NOT TRUE', 'FALSE', 'NOT FALSE', 
		'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP'
    ];

    private \mysqli $_connect;
    private \mysqli_result|bool|null $_result = null;

    function connect(string $hostname, string $database, string $username, ?string $password = null, int $port = 0){
        $this->_connect = new \mysqli($hostname, $username, $password, $database, $port ?: 3306);

        if($this->_connect->connect_error){
            $this->debugAddError();
            throw('<b>Приносим наши извинения!</b> <br/>В настоящее время на сайте ведутся технические работы!<br/>');
        }

        $this->_connect->set_charset('utf8');
        $this->_connect->query("SET SQL_MODE=''");
    }

    function disconnect() {
        $this->_connect->close();
    }

    function query(string $sql, ?array $params): bool {
        if(static::$debug){
            $this->debugLog($sql, 'QUERY');
            if($params !== null)
                $this->debugLog('params = ['.implode(',', $params).']', 'QUERY');
            $timer = microtime(true);
        }

        if($params === null)
            $this->_result = $this->_connect->query($sql);
        else {
            $sql = strtr($sql, ['$?' => '?']);
            $this->_result = $this->_connect->execute_query($sql, $params);
        }

        if(static::$debug)
            $this->debugLog('worked time: '.sprintf('%0.8f', microtime(true) - $timer), "QUERY");
        return !!$this->_result;
    }

    function queryClose(string $sql, ?array $params): int {
        $result = $this->query($sql, $params);
        if($result){
            $temp = $this->affectRows();
            if($this->_result instanceof \mysqli_result)
                $this->_result->free();
            return $temp;
        }
        return 0;
    }

    function rowsCount(): int {
        if(!$this->_result) return -1;
        return $this->_result->num_rows;
    }

    function affectRows(): int {
        if($this->_result) return -1;
        return $this->_connect->affected_rows;
    }

    function countFields(): int {
        if(!$this->_result) return 0;
        return $this->_result->field_count;
    }

    function getFields(): array {
        if(!$this->_result) return [];

        $result = [];
        $count = $this->_result->field_count;
        if($count > 0)
            for($i = 0; $i < $count; $i++)
                $result[] = $this->_result->fetch_field_direct($i);
        return $result;
    }

    function getNameFields(): array{
        return array_map(fn($field)=>$field->name, $this->getFields());
    }

    function resultAll(bool $typeResult = self::TYPE_OBJECT, ?string $className = null, array $args = []): array {
        if(!$this->_result) return [];
        if($typeResult == self::TYPE_ASSOC){
            $rows = $this->_result->fetch_all(MYSQLI_ASSOC);
            $this->_result->free();
            return $rows;
        }

        $rows = [];
        while($row = $this->_result->fetch_object($className ?? 'stdClass', $args))
            $rows[] = $row;
        $this->_result->free();
        return $rows;
    }

    function esc_db(mixed $value, string $temp) {
        if(!in_array($temp, static::VALUE_NO_STRING))
            $value = "'" . $this->_connect->escape_string($value) . "'";
        return $value;
    }

    function limit(int $offset, int $limit): string {
        return " LIMIT ".($offset > 0 ? $offset.',' : '').$limit;
    }

    function insertGetId(string $sql, ?array $params): int {
        $this->queryClose($sql, $params);
        return $this->_connect->insert_id;
    }

    function debugAddError(){
        $this->debugLog($this->_connect->error.' (#'.$this->_connect->errno.')', 'ERROR');
    }
}