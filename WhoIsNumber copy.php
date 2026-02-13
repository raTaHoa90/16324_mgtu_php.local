<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Угодай число</title>
</head>
<body>
    <?php
        if(isset($_GET['run'])){
            $guess = $_GET['run'];
            $variant = $_GET['variant'];

            if($guess == $variant)
                echo 'Поздравляею, вы угадали число!!!';
            else
                echo "Увы, было загадано число $guess, а не $variant";
            echo '<br>Сервер загадал новое число, попробуйте угадать его.<br>';
        } else 
            echo 'Сервер загадал число, попробуйте угадать его.<br>';

        $guess = rand(0, 999);
        $guessStr = ''.$guess;

        echo '<ul>';

        echo '<li>Загаданное число <b>';
        if($guess % 2 == 1)
            echo 'не';
        echo 'четное</b>';

        echo '<li>Загаданное число состоит из ' . strlen($guessStr) . ' символов';

        switch(strlen($guessStr)){
            case 1: break;
            case 2: 
                if($guessStr[0] == $guessStr[1])
                    echo '<li>Загаданное число явняется Число-палиндром';
                break;

            case 3:
                if($guessStr[0] == $guessStr[2])
                    echo '<li>Загаданное число явняется Число-палиндром';
                break;

            default: echo '<li><b style="color: red">не предусмотренное значение</b>';
        }

        echo '</ul>';
    ?>
    <hr>
    <form action="?" method="GET">
        <input type="hidden" value="<?= $guess ?>" name="guess">
        <table>
            <tr>
                <td>Введите число от 0 до 999: </td>
                <td><input type="number" name="variant" placeholder="999"></td>
            </tr>
            <tr><td></td><td><input type="submit" name="run" value="Проверить"></td></tr>
        </table>
    </form>
    
</body>
</html>