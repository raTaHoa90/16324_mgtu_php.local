<?php
class BaseObject {

    const DEFAULT_CITY = "Москва";

    public string $name;
    protected string $_city;
    private int $_age; 

    static private $_countObjects = 0;
    static function count(): int {
        return static::$_countObjects;
    }

    function __construct(string $name, int $age, string $city = self::DEFAULT_CITY) {
        $this->name = $name;
        $this->_city = $city;
        $this->_age = $age;

        static::$_countObjects++;
        //echo static::class.' ';
        //echo self::class.' ';
        //echo __CLASS__.'<br>';
    }

    function speak(){
        echo 'my name is '.$this->getName().' (age = '.$this->_age.')<br>';
    }

    function getName(): string {
        return $this->name;
    }

    protected function getAge(): int {
        return $this->_age;
    }
}

class Human extends BaseObject {
    function getName(): string {
        return ' human '.$this->name.' city='.$this->_city;
    }

    private function infoOne($a){
        return $a * 2;
    }

    private function infoTwo($a, $b){
        return $a + $b;
    }

    private function infoThree($a, $b, $c){
        return ($a + $b) / $c;
    }

    function info(...$args){
        switch(count($args)){
            case 1: return $this->infoOne($args[0]);
            case 2: return $this->infoTwo(...$args);
            case 3: return $this->infoThree(...$args);
        }
        return null;
    }
}

class Animal extends BaseObject {
    public string $breed;

    function __construct(string $name, int $age, string $breed) {
        parent::__construct($name, $age);
        $this->breed = $breed;
    }

    function getName(): string {
        return ' animal ('.$this->breed.') '.parent::getName().' city='.$this->_city;
    }
}

class SuperClass {
    private array $_fields = [];

    /**
     * Конструктор объекта, собирает объект и позволяет инициировать данные внутри объекта
     */
    function __construct(array $ar = []){
        $this->_fields = $ar;
    }

    /**
     * Геттер, вызывается тогда, когда указанного в коде поля не существует
     */
    function __get($name) {
        return $this->_fields[$name] ?? null;
    }

    /**
     * Сеттер, вызывается тогда, когда под несуществующее поле, 
     * пытаются что-то сохранить
     */
    function __set($name, $value) {
        $this->_fields[$name] = $value;
    }

    /**
     * Вызывается тогда, когда необходимо проверить 
     * существование поля в объекте
     */
    function __isset($name) {
        return isset($this->_fields[$name]);
    }

    /**
     * Вызывается вместо несуществующего метода, с указанием его имени
     */
    function __call($name, $arguments)
    {
        return $name.'('.count($arguments).')';
    }

    /**
     * аналогично __call, но для статики
     */
    static function __callStatic($name, $arguments)
    {
        return 'static '.$name.'('.count($arguments).')';
    }


    /**
     * Вызывается когда объект уже нигде не нужен и 
     * сборщик мусора хочет его уничтожит
     */
    function __destruct()
    {
        
    }

    /**
     * Вызывается, когда ключ пытаются уничтожить
     */
    function __unset($name) {
        unset($this->_fields[$name]);
    }

    /**
     * вызывается, когда PHP уходит в сон
     * тут можно например описать отключение от БД или други ресурсов, что бы за зря их не держать
     */
    function __sleep() {
        
    }

    /**
     * вызывается, когда PHP возвращается из спящего режима
     * тут можно например переподключиться к БД или переоткрыть файл
     */
    function __wakeup()
    {
        
    }

    /**
     * вызывается когда объект пытаются преобразовать в строку
     */
    function __toString()
    {
        return 'count('.count($this->_fields).')';
    }

    /**
     * вызывается, когда мы пытаемся клонировать объект (clone)
     */
    function __clone()
    {
        $new = new static();
        
        // $new2 = new self();
        // $new3 = new Superclass();

        $new->_fields = $this->_fields;
        return $new;
    }

    /**
     * Вызывается, когда мы хотим получить дамп объекта через var_dump
     */
    function __debugInfo()
    {
        return $this->_fields;
    }

    /**
     * Вызывается при сериализации объекта
     */
    function __serialize(): array
    {
        return $this->_fields;
    }

    /**
     * Обратные действия __serialize
     */
    function __unserialize(array $data): void
    {
        $this->_fields = $data;
    }

    /**
     * Вызывается, когда объект пытаются использовать как функцию
     */
    function __invoke($name)
    {
        return $this->_fields[$name] ?? null;
    }
}

//$obj = new BaseObject('test');
//$obj->speak();
//$obj = (object)['a'=>1,'b'=>2]; // StdObject{ public $a = 1,$b = 2; }

$human = new Human('Максим', 38, 'Краснодар');
$duck = new Animal('Гага', 1, 'Утка');
$dog = new Animal('Рекс', 5, 'Собака');
$cat = new Animal('Пушок', 3, 'Кошка');

echo BaseObject::count().'<br>';

$entities = [$human, $duck, $dog, $cat];
foreach($entities as $entity)
    /** 
     * @var BaseObject $entity 
     */
    $entity->speak();

echo $human->info(15).' '.$human->info(5,6).' '.$human->info(4,3,2);

$nm = 'name';
$md = 'info';
$human->$nm = 'Иван';
echo '<br>'.$human->name.' '.$human->$nm.' '.$human->$md(9);

//var_dump($human);
$obj = (object)[
    'name' => 'test',
    'age' => 10
];
$obj->test = '123';
var_dump($obj);

$ar = ['a'=>1,'b'=>2];
$ar2 = $ar;
$ar['a'] = 5;
var_dump($ar2, $ar);

$obj = (object)$ar;
$obj2 = $obj;
$obj->b = 100;
var_dump($obj2, $obj);

$name = 'b';
echo $obj->{$name};

$human2 = clone $human;
$human->name .= ' II';
var_dump($human, $human2);

//==================================
echo '<hr>';

$super = new Superclass();
$super->test = 1;
$super->test2 = "value";
if(!isset($super->test3)) echo 'test3 not Found<br>';
var_dump($super);

echo $super->test . ' ' . $super->method(1,2,3).'<br>';
echo Superclass::method2(3,2,1,0,4,5);

echo '<hr>';
var_dump($super);
$serSuper = serialize($super);
echo $serSuper.'<br>';
$super2 = unserialize($serSuper);
var_dump($super2);

echo $super("test");