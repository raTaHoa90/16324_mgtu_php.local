<?php

namespace lib;

final class Route {
    private string $_type;  // GET || POST
    private array $_pathes; // путь по которому прошел пользователь

    private string $_controller; // контроллер, который необходимо загрузить
    private string $_method;     // метод, который необходимо выполнить в контролере
    private string $_name;

    public array $varibles = [];

    function __construct(string $type, string $path, string $binding) {
        $this->_type = $type;

        // разбиваем указанный путь на массив
        // /example/@path/test => ['example', '@path', 'test']
        $pathes = explode('/', $path);
        $this->_pathes = [];
        foreach($pathes as $path)
            if(trim($path) != '')
                $this->_pathes[] = trim($path);
                // ex//test => ex/test
                // ex / test => ex/test
        
        if(!$this->_pathes)
            $this->_pathes[] = '';

        // classname@method#namePath => ['classname', 'method', 'namePath']
        $temp = preg_split("/[@#]/", $binding);
        if(strpos($binding,'@') === false && isset($temp[1])){
            $temp[2] = $temp[1];
            unset($temp[1]);
        }

        $this->_controller = strtr($temp[0], ['/'=>'\\']);
        $this->_method = $temp[1] ?? 'index';

        if(!isset($temp[2])){
            $this->_name = $this->_pathes[count($this->_pathes)-1];
            if($this->_name == '' || $this->_name[0] == '@')
                $this->_name = $this->_method;
        } else
            $this->_name = $temp[2];
    }

    function compare(string $type, array $pathes): bool {
        if($type != $this->_type && $this->_type != 'ANY')
            return false;

        if(count($pathes) != count($this->_pathes))
            return false;

        $this->varibles = [];
        foreach($pathes as $i => $path)
            if($this->_pathes[$i] && $this->_pathes[$i][0] == '@')
                $this->varibles[substr($this->_pathes[$i], 1)] = $path;
            elseif($this->_pathes[$i] != $path)
                return false;

        return true;
    }

    function Invoke(){
        $path = config('app.paths.conrollers', 'Controller');
        $path = trim($path, ".\\/");
        $path = strtr($path, ['/' => '\\']);
        $objController = new ($path.'\\'.$this->_controller)($this->_name);
        if(method_exists($objController, $this->_method))
            $objController->{$this->_method}($this->varibles);
        else
            throw "ERROR: Controller not found";
    }
}