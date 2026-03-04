<?php
interface IWings {
    function Fly();
    function isFly(): bool;
    function Landing();
    function MaxHeightFly(): float;
    function MaxDistance(): float;
}

interface IFoot {
    function Step(int $countSteps);
    function Running();
    function isStep(): bool;
    function isRunning(): bool;
    function Stop();
}

trait TwoLegs {
    private int $_step = 0;
    private bool $_isRunning = false;

    function Step(int $countSteps){
        $this->_step = $countSteps;
    }

    function Running(){
        $this->_isRunning = true;
    }

    function isStep(): bool{
        return $this->_step > 0;
    }

    function isRunning(): bool{
        return $this->_isRunning;
    }

    function Stop(){
        $this->_isRunning = false;
        $this->_step = 0;
    }
}

trait DefaultWings {
    private bool $_isFly = false;
    function Fly() {
        $this->_isFly = true;
    }

    function isFly(): bool {
        return $this->_isFly;
    }

    function Landing(){
        $this->_isFly = false;
    }

    function MaxHeightFly(): float {
        return 100;
    }

    function MaxDistance(): float {
        return 20;
    }
}


class BaseEntity {
    public $name;
    function __construct(string $name) {
        $this->name = $name;
    }
}

class Animal2 extends BaseEntity { }
class Bird extends Animal2 { }

class Human extends BaseEntity implements IFoot {
    use TwoLegs;
}

class Duck extends Bird implements IWings, IFoot {
    use TwoLegs, DefaultWings;

    function MaxDistance(): float{
        return 50;
    }
}

$fabrics = [
    Human::class,
    Duck::class,
];

$entities = [];
for($i = 0; $i < 10; $i++)
    $entities[] = new $fabrics[rand(0, count($fabrics)-1)]("Object $i");

function infoFly(IWings $obj){
    echo 'is WINGS ';
    echo $obj->isFly() ? 'FLY ' : 'Land ';
}

function infoFoot(IFoot $obj){
    echo 'is FOOT ';
    if($obj->isRunning())
        echo 'Running ';
    elseif($obj->isStep())
        echo 'Steps ';
    else
        echo 'Stop ';
}

//.............
foreach($entities as $entity)
    if(is_object($entity) && $entity instanceof BaseEntity){
        echo 'type('.get_class($entity).') Name: '.$entity->name.' ';

        if($entity instanceof IFoot)
            infoFoot($entity);

        if($entity instanceof IWings)
            infoFly($entity);

        echo '<br>';
    }