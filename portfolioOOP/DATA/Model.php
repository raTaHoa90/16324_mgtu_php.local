<?php

namespace DATA;

use lib\DB\DataBase;
use lib\SYS;

class Model {
    private array $fields = [];
    public int $id;

    private bool $_is_new = false;

    static function allWhere(string $where = ''): array {
        return static::table('SELECT * FROM '.static::getTable(). ($where ? " WHERE $where" : ''));
    }

    static function count(string $where = ''): int {
        $result = SYS::$DB->query('SELECT count(*) as count_row FROM '.static::getTable(). ($where ? " WHERE $where" : ''), []);
        return isset($result[0]) ? $result[0]->count_row : 0;
    }

    static function all(): array {
        return static::allWhere('');
    }

    static function table(string $sql, ?array $params = null){
        return SYS::$DB->table($sql, $params, DataBase::TYPE_OBJECT, static::class);
    }

    static function find(int $id){
        $result = static::table('SELECT * FROM '.static::getTable().' WHERE id=$? LIMIT 1', [$id]);
        return $result[0] ?? null;
    }

    // UserTopicMessages => user_topic_messages
    static private function _class_to_table_name(string $name){
        $name = basename($name);
        $name = preg_replace('/([A-Z])/', '_\1', $name);
        return strtolower(trim($name, "_"));
    }

    static function getTable(){
        return static::class == self::class
            ? false
            : static::_class_to_table_name(static::class);
    }

    static function create(array $data): static {
        $obj = new static($data);
        $obj->save();
        return $obj;
    }

    function save(){
        if($this->_is_new){ // INSERT
            $insert = 'INSERT INTO '.static::getTable().'(';
            $values = [];
            $firstKey = true;
            foreach($this->fields as $key => $value){
                $insert .= ($firstKey ? '' : ', '). $key;
                $firstKey = false;
                $values[] = $value;
            }
            $insert .= ') VALUES (';
            for($i = 0; $i < count($values); $i++)
                $insert .= ($i > 0 ? ', ' : ''). '$?';
            $insert .= ')';

            $this->id = SYS::$DB->insertGetId($insert, $values);
            
            $this->_is_new = false;
        } else { // UPDATE
            $update = 'UPDATE '.static::getTable().' SET ';
            $values = [];
            $firstKey = true;
            foreach($this->fields as $key => $value){
                $update .= ($firstKey ? '' : ', '). $key;
                $firstKey = false;
                $values[] = $value;
            }
            $update .= ' WHERE id='.$this->id;

            SYS::$DB->queryClose($update, $values);
        }
    }

    function delete(){
        SYS::$DB->queryClose('DELETE FROM '.static::getTable().' WHERE id='.$this->id, []);
    }

    function __construct($data = null)  // [] = создаем новую запись, null - запись загрузилась из БД
    {
        if($data === null) return;

        $this->id = $data['id'] ?? -1;
        unset($data['id']);
        $this->fields = $data;
        $this->_is_new = true;
    }

    function __get($name) {
        if($name == 'id') 
            return $this->id;
        return $this->fields[$name] ?? null;
    }

    function __set($name, $value) {
        if($name == 'id')
            $this->id = $value;
        else
            $this->fields[$name] = $value;
    }

    function __isset($name){
        return array_key_exists($name, $this->fields);
    }

    function __unset($name){
        unset($this->fields[$name]);
    }

    function getData(){
        $data = $this->fields;
        $data['id'] = $this->id;
        return $data;
    }
}