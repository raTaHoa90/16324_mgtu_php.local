<?php
    include_once 'includes/WhoIsNumber.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Угодай число</title>
</head>
<body>
    <?php
        $guess = -100;
        $countAttempts = RunsIsGet($_GET, $guess);
        
        if($countAttempts <= 0) {
            $guess = rand(0, 999);
            $countAttempts = 3;
        }

        echo '<ul>';
        EvenOrOdd($guess);
        CountChars($guess);
        HasNumberReverse($guess);

        echo '</ul>';
    ?>
    <hr>
    <form action="?" method="GET">
        <input type="hidden" value="<?= $guess ?>" name="guess">
        <input type="hidden" value="<?= $countAttempts ?>" name="countAttempts">
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