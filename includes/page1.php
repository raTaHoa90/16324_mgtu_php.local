<?php
// [a-zA-Z_]+[a-zA-Z_0-9]*
echo "Run Page1<br>";

$test = 12312;

/*
    int - число
    float - вещественное значение (десятичное число)
    srting - строка
    bool - логический тип (булевой) (false/true)
    array - массивы
    null - пустая ссылка
    object - объект
    callable - функция
    resource - ресурс
    void - отсутствие значения
*/

$a = 8;
$b = 3;
$c = -5;

echo ($a + $b) . '<br>';
echo ($a - $b) . '<br>';
echo ($a * $b) . '<br>';
echo ($a / $b) . '<br>';
echo ($a % $b) . '<br>';
echo ($a ** $b) . '<br>';
echo ($a + $b + $c * ($a - $b)) . '<br>';
echo -$a . '<br>';

$result = $a + $b + $c;
echo $result.'<br>';
echo $a . ' + ' . $b . ' = ' . ($a + $b) . '<br>';

$a = $a | $b; // бинарное ИЛИ
$a = $a & $b; // бинарное И
$a = $a ^ $b; // бинарное xor (ЛИБО)
$a = ~$a;     // бинарное НЕ

$a = 0b0101; 
$b = $a << 2; // => 0b10100 => 24
$c = $a >> 1; // => 0b010 => 2

$bit = 0b0101; // => 5
$hex = 0x1A;   // => 26
$oct = 0o123;  // => 83
$oct2= 0123;   // => 83
$dec = 1234567;
$dec = 1_234_567;

$a = 1.234;
$b = 1.2e3; // 1.2 * 10**3 = 1.2 * 1000 => 1200
$c = 7e-10; // 7 * 10 ** (-10) => 0.0000000007
$d = 1_234.567;
$inf = INF;
$mInf = -INF;
$notANumber = NAN;

$no = false;
$yes = true;
$equ = $a == $b; // сравнивает A равен ли B
$notEqu = $a != $b;
$equ = $a === $b; // проверка абсолютное равенство А и B
$lt  = $a < $b;
$lte = $a <= $b;
$gt  = $a > $b;
$gte = $a >= $b;

$cmp = $a <=> $b; // -1 = A > B; 0 = A == B; 1 = A < B

$and = $lte && $equ; // логическое И
$or  = $gt || $lt;   // логическое ИЛИ
$not = !$equ;        // логическое НЕ
$and = $lte and $gt; // логическое И
$xor = $lte xor $gt; // логическое XOR
$or  = $lte or $gt;  // логическое ИЛИ

echo '<hr>FALSE = "'.false.'"<br>';
echo 'TRUE = "'.true.'"<br><hr>';

// false, 0, '', '0', null, []  EQU false
echo '' ? 'TRUE ' : 'FALSE ';
echo '0' ? 'TRUE ' : 'FALSE ';
echo '1' ? 'TRUE ' : 'FALSE ';
echo 0 ? 'TRUE ' : 'FALSE ';
echo 1 ? 'TRUE ' : 'FALSE ';
echo null ? 'TRUE ' : 'FALSE ';
echo [] ? 'TRUE ' : 'FALSE ';
echo [0] ? 'TRUE ' : 'FALSE ';
echo [[]] ? 'TRUE ' : 'FALSE ';

echo ('0' + '1').'<hr>';

// STRING
echo 'string \n test $a\\ \' \"<br>';
echo "string \n test $a\\ \' \"<br>";
echo "текст 'Название'";

$heredoc = <<<END
    Тут какой-то \\
    очень длинный \t
    многострочный 'текст'
    и можно "вставлять" переменные $a <br>
END;

$nowdoc = <<<'CUSTOM_TEXT_END'
    Тут какой-то \'
    очень длинный \\ \t
    многострочный 'текст'
    и можно "вставлять" переменные $a <br>
CUSTOM_TEXT_END;

echo $heredoc;
echo $nowdoc;

// ARRAY
$a = array(1, array(2, array(5, 'text')), 3, 4);
$a = [1, [2, [5, 'text']], 3, 4];
$array = [1, 2, true, 'text', 4.4, false, null];
echo $array[0]; // => 1
echo $array[3]; // => text

$array[2] = 'true';
$array[10] = 'где-то далеко';
$array[] = 'new value';
$array['test'] = 'Это не числовой индекс';
$array2 = ['1' => 15, 5 => null, 'а это будет 6', 'test' => 'text', 'даже русский текст' => '???'];
unset($array2[1]);
$isKey = isset($array2[1]);
$isKey = array_key_exists(1, $array2);
$countElements = count($array2);
$keys = array_keys($array2);

echo '<hr>' . implode(',', $keys);
$array = explode(',', '1,2,3,4,5,6');
echo '<br>' . implode(',', $array)."<br>\n";

print_r($array2);
print_r($keys);

var_dump($array2, $a, $lt, $b);

if(true) 
    echo 'TRUE';
else 
    echo 'FALSE';

if($a > $b)
    echo 'a > b';
elseif($a < $b)
    echo 'a < b';
else 
    echo 'a = b';

if(true)
    echo 'TEST';

if(true) {
    echo 'TEST 1<br>';
    echo 'TEST 2<br>';
    echo $b;
}

$findstr = '.';

// дополнительные функции для различной математике
$guess = rand(0, 999);  // получаем случайное число от 0 до 999
$str = ''.$guess;       // преобразуем число в строку
$len = strlen($str);    // узнать длину строки в байтах
$len = mb_strlen($str); // узнать длину строки в символах
$pos = strpos($str, $findstr);    // возвращает индекс начала строки поиска, и FALSE, если искомая строка не найдена в строке
$pos = mb_strpos($str, $findstr); // возвращает индекс начала строки поиска, и FALSE, если искомая строка не найдена в строке

if($pos === false)
    echo 'Строка не найдена';

$round = round(5.0 / 2); // => 2.5 => 3
$int = (int)(5.0 / 2);   // => 2.5 => 2
$sin = sin(1.2);
$cos = cos(1.2);
$tang= tan(1.2);
$log = log(1.2);
$lten= log10(1.2);

//M_PI
//M_E
$pi = pi();
$power = pow(2, 0.5); // 2 ** 0.5

echo '<hr>';