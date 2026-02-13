<?php
function RunsIsGet(array $variables, int &$guess): int {
    $countAttempts = $variables['countAttempts'] ?? 0;
    $countAttempts--;

    if(isset($variables['run'])){
        $guess = $variables['run'] ?? -100;
        $variant = $variables['variant'] ?? -1;

        if($guess == $variant)
            echo 'Поздравляею, вы угадали число!!!';
        elseif($countAttempts > 0)
            echo "Увы, было загадано не $variant, у вас осталось $countAttempts попыток";
        else
            echo "Увы, было загадано число $guess, а не $variant";
        echo '<br>';
    } else 
        $guess = -100;
    echo 'Сервер загадал число, попробуйте угадать его.<br>';

    return $countAttempts;
}

function EvenOrOdd(int $guess): void {
    echo '<li>Загаданное число <b>';
    if($guess % 2 == 1)
        echo 'не';
    echo 'четное</b>';
}

function CountChars(string $guess): void {
    echo '<li>Загаданное число состоит из ' . strlen($guess) . ' символов';
}

function HasNumberReverse(string $guess): void{
    switch(strlen($guess)){
        case 1: break;
        case 2: 
            if($guess[0] == $guess[1])
                echo '<li>Загаданное число явняется Число-палиндром';
            break;
        case 3:
            if($guess[0] == $guess[2])
                echo '<li>Загаданное число явняется Число-палиндром';
            break;

        default: echo '<li><b style="color: red">не предусмотренное значение</b>';
    }
}