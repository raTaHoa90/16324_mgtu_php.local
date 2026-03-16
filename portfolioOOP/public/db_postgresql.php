<?php

include "../DATA/Model.php";
use DATA\Model;

    // Подключение к БД MySQL
    $str_connection = "host=127.127.126.22 port=5432 user=postgres dbname=php_lern";
    $connection = @pg_connect($str_connection);
    

    if(!$connection)
        die("<b>Приносим наши извинения!</b> <br/>В настоящее время на сайте ведутся технические работы!<br/>");


    // обновить данные пользователя
    $result = pg_query_params($connection,
        "UPDATE users SET description = $1 WHERE description IS NULL",
        ['Нет описания']
    );
    $rowAffect = pg_affected_rows($result);

    // получаем всех пользователей
    $result = pg_query($connection, "SELECT * FROM users WHERE fio IS NOT NULL ORDER BY fio");
    $users = [];
    while($row = pg_fetch_object($result, null, Model::class, []))
        $users[] = $row;
    pg_free_result($result);

    // Получаем количество записей в таблице пользователей
    $result = pg_query($connection, "SELECT count(*) AS count_users FROM users");
    $countUsers = pg_fetch_assoc($result)['count_users'];
    pg_free_result($result);

    // создаем новую запись пользователя
    $result = pg_query_params($connection,
        "INSERT INTO users(login, \"password\", fio, tel, description) VALUES ($1, $2, $3, $4, $5) RETURNING id", [
            'UserPHP_'.$countUsers,
            '123123',
            'Иванов А.А.',
            '123456789',
            'В тут какоу-то описание нового пользователя'
    ]);

    $idUser = pg_fetch_assoc($result)['id'];
    pg_free_result($result);

    $result = pg_query_params($connection, "SELECT * FROM users WHERE id=$1 LIMIT 1", [$idUser]);
    $newUser = pg_fetch_object($result, null, Model::class, []);
    pg_free_result($result);

    // закрываем соединение с БД
    @pg_close($connection);
?>

Всего пользователей: <?= $countUsers ?><br>
ID созданного пользователя: <?= $idUser ?><br>
Измененные строки: <?= $rowAffect ?><br><br>

<table border=1 cellpadding=10>
    <?php foreach($users as $user): if(isset($user->fio)): ?>
    <tr id="user_<?= $user->id ?>">
        <td><?= $user->id ?></td>
        <td><?= $user->login ?></td>
        <td><?= $user->fio ?></td>
        <td>
            <?php if(isset($user->avatar) && $user->avatar): ?>
            <img width="200" src="/storage/avatars/<?= $user->avatar ?>">
            <?php endif; ?>
        </td>
        <td class="desc"><?= strtr($user->description ?? '', ["\n"=>'<br>']) ?></td>
        <td><b>Контакты:</b><br>
        <?php if($user->tel): ?>
            <a href="tel:<?= $user->tel ?>"><i class="fa fa-mobile"></i> <?= $user->tel ?></a><br>
        <?php endif; if($user->email): ?>
            <a href="mailto:<?= $user->email ?>"><i class="fa fa-envelope-o"></i> <?= $user->email ?></a><br>
        <?php endif; if($user->telegram): ?>
            <a href="https://t.me/<?= substr($user->telegram, 1) ?>"><i class="fa fa-telegram"></i> <?= $user->telegram ?></a><br>
        <?php endif; ?>
        </td>
    </tr>
    <?php endif; endforeach; ?>

    <tr><td colspan=5><hr></td></tr>
    <tr id="user_<?= $newUser->id ?>">
        <td><?= $newUser->id ?></td>
        <td><?= $newUser->login ?></td>
        <td><?= $newUser->fio ?></td>
        <td>
            <?php if(isset($newUser->avatar) && $newUser->avatar): ?>
            <img width="200" src="/storage/avatars/<?= $newUser->avatar ?>">
            <?php endif; ?>
        </td>
        <td class="desc"><?= strtr($newUser->description ?? '', ["\n"=>'<br>']) ?></td>
        <td><b>Контакты:</b><br>
        <?php if($newUser->tel): ?>
            <a href="tel:<?= $newUser->tel ?>"><i class="fa fa-mobile"></i> <?= $newUser->tel ?></a><br>
        <?php endif; if($newUser->email): ?>
            <a href="mailto:<?= $newUser->email ?>"><i class="fa fa-envelope-o"></i> <?= $newUser->email ?></a><br>
        <?php endif; if($newUser->telegram): ?>
            <a href="https://t.me/<?= substr($newUser->telegram, 1) ?>"><i class="fa fa-telegram"></i> <?= $newUser->telegram ?></a><br>
        <?php endif; ?>
        </td>
    </tr>
</table>