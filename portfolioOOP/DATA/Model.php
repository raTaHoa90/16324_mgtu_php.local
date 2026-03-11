<?php

namespace DATA;

class Model {
    private array $fields = [];
    public int $id;

    function __construct($data)
    {
        $this->id = $data['id'] ?? 0;
        unset($data['id']);
        $this->fields = $data;
    }

    function __get($name) {
        return $this->fields[$name] ?? null;
    }

    function __set($name, $value) {
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