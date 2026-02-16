<?php
$cars = ['bwm', 'audi', 'kia', 'vaz'];

$i = 0;
echo '<h3>WHILE</h3><ul>';
while($i < count($cars)) {
    echo '<li>'.$cars[$i].'</li>';
    //$i = $i + 1;
    //$i += 1;
    $i++;
}
echo '</ul><hr>';

$i = 0;
echo '<h3>DO WHILE</h3><ul>';
do {
    echo '<li>'.$cars[$i].'</li>';
    $i++;
} while ($i < count($cars));
echo '</ul><hr>';

echo '<h3>FOR</h3><ul>';
for($i = 0; $i < count($cars); $i++)
    echo '<li>'.$cars[$i].'</li>';
echo '</ul><hr>';

echo '<h3>FOREACH (value)</h3><ul>';
foreach($cars as $car) // JS => for(let car of cars)
    echo "<li>$car</li>";
echo '</ul><hr>';

echo '<h3>FOREACH (key => value) </h3><ul>';
foreach($cars as $i => $car)
    echo "<li>$car($i)</li>";
echo '</ul><hr>';

$arr = $cars; // $arr = clone $cars
$arr = &$cars;
$arr[] = 'kamaz'; // $cars[] = 'kamaz';


echo '<h3>FOREACH (key => ref value)</h3>';
print_r($cars);
echo '<ul>';
foreach($cars as $i => &$car) {
    $car .= "($i)";
    //$car = $car . "($i)";
    echo "<li>$car</li>";
}
echo '</ul>';
print_r($cars);
echo '<hr>';

$a = 'b';
$b = 'c';
$c = 'd';
$d = 123;

echo '<br>'.$$$$a.' '; // => $$$b => $$c => $d => 123
$$$$a = 321;
echo $d.' '; // => 321;

${$b . '123'} = 321; // c123 = 321;

$func = 'count';
echo $func($cars); // count($cars);