<?php

interface ITag {};
interface ITagTwo extends ITag {
    function getID();
}

class CustomIterable implements Iterator { // для работы итерирования объекта через foreach
    private $_ar;
    private $i;

    function __construct($ar)
    {
        $this->_ar = $ar;
        $this->i = 0;
    }

    function current(): mixed {
        // возвращает текущее значение шага
        return $this->_ar[$this->i];
    }

    function key(): mixed {
        // возвращает текущий ключ шага
        return $this->i;
    }

    function next(): void {
        // переходим на следующий шаг чтения
        $this->i++;
    }

    function rewind(): void {
        // перезапускаем итератор (т.е. начинаем бежать по массиву заного)
        $this->i = 0;
    }

    function valid(): bool {
        // возвращает True, пока нам есть по чему бежать, и false, если больше нет необработанных значений
        return $this->i < count($this->_ar);
    }

}

$meArray = new CustomIterable([1, 321, "TESTER"]);
foreach($meArray as $key => $value)
    echo "[$key] => '$value'<br>";

//========================================================================================
//========================================================================================
//========================================================================================
//========================================================================================
//========================================================================================

class CustomArray implements IteratorAggregate, ArrayAccess, Countable {
    private array $_ar;

    function __construct(array $ar) {
        $this->_ar = $ar;
    }

    // interface IteratorAggregate
    function getIterator(): Traversable {
        return new ArrayIterator($this->_ar);
    }

    // interface Countable
    function count(): int {
        return count($this->_ar);
    }

    // interface ArrayAccess
    function offsetExists(mixed $offset): bool {
        return array_key_exists($offset, $this->_ar);
    }

    function offsetGet(mixed $offset): mixed {
        return $this->_ar[$offset];
    }

    function offsetSet(mixed $offset, mixed $value): void {
        if($offset === null)
            $this->_ar[] = $value;
        else
            $this->_ar[$offset] = $value;
    }

    function offsetUnset(mixed $offset): void {
        unset($this->_ar[$offset]);
    }
}


echo '<br><hr>';
$meArray = new CustomArray(['test'=>1, 123=>321, 'text'=>"TESTER"]);

$meArray['key1'] = 123;
$meArray[] = 432;

foreach($meArray as $key => $value)
    echo "[$key] => '$value'<br>";

echo count($meArray);
echo $meArray->count();

/* Операторы ловли исключения
try{
    тут код который может создать ошибку/исключение
    
    throw new Exception('TEST'); // создать свое исключение
}catch(Exception $e){
    ловим исключение/ошибку класса Exception

    echo 'ERROR: '.$e->getMessage();
}catch(Throwable $e){
    ловим любое исключение/ошибку
    throw new Exception('TEST '.$e->getMessage());
}finally {
    выполняем этот код независимо от того произошла ошибка или нет
}*/

//  Generator > Iterator
function fib($n){
    $current = 1;
    $back = 0;
    for($i = 0; $i < $n; $i++){
        yield $current;

        $temp = $current;
        $current = $back + $current;
        $back = $temp;
    }
}

echo '<br><hr>';
$fibonachi = fib(9);
foreach($fibonachi as $value)
    echo ' '.$value;

echo '<br>';
$fibs = [...fib(15)];
echo implode(' ', $fibs);

enum StateLoader: int {
    case Start = 1;
    case PreLoad = 2;
    case Load = 3;
    case UnLoad = 4;

    function to_str(){
        return match($this){
            static::Start => 'Start',
            static::PreLoad => 'PreLoad',
            static::Load => 'Load',
            static::UnLoad => 'UnLoad',
            default => ''
        };
    }
}

$state = StateLoader::Load;
$value = match($state){
    StateLoader::Start => 10,
    StateLoader::PreLoad => 2,
    default => -1
};

echo '<br>'. $value .' '. $state->to_str();
var_dump($state, $state == 3);
var_dump($state == StateLoader::Load);
var_dump(StateLoader::cases());
var_dump(StateLoader::from(2));
var_dump($state->value);