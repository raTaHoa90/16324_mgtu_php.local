<?php

include "../DATA/Model.php";
use DATA\Model;

    // Подключение к БД MySQL
    $connection = new mysqli('127.127.126.26', 'root', null, 'php_lern', 3306);

    if($connection->connect_error)
        die("<b>Приносим наши извинения!</b> <br/>В настоящее время на сайте ведутся технические работы!<br/>");

    $connection->set_charset("utf8");
    $connection->query("SET SQL_MODE = ''");


    // обновить данные пользователя
    $connection->execute_query("UPDATE users SET description = ? WHERE description IS NULL",
        ['Нет описания']
    );
    $rowAffect = $connection->affected_rows;

    // получаем всех пользователей
    $result = $connection->query("SELECT * FROM users WHERE fio IS NOT NULL ORDER BY fio");
    $users = [];
    while($row = $result->fetch_object(Model::class, []))
        $users[] = $row;
    $result->free();

    // Получаем количество записей в таблице пользователей
    $result = $connection->query("SELECT count(*) AS count_users FROM users");
    $countUsers = $result->fetch_assoc()['count_users'];
    $result->free();

    // создаем новую запись пользователя
    $connection->execute_query("INSERT INTO users(login, `password`, fio, tel, description) VALUES (?, ?, ?, ?, ?)",[
        'UserPHP_'.$countUsers,
        '123123',
        'Иванов А.А.',
        '123456789',
        'В тут какоу-то описание нового пользователя'
    ]);

    $idUser = $connection->insert_id;
    $result = $connection->execute_query("SELECT * FROM users WHERE id=? LIMIT 1", [$idUser]);
    $newUser = $result->fetch_object(Model::class, []);
    $result->free();

    // закрываем соединение с БД
    $connection->close();
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