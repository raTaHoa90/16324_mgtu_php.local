<?php
    include_once "DATA/usersFriends.php";
    $friends = getFriendsByUserID($user['id']);
?>

<div class="panel">
    <div class="avatar" style="background-image: url(<?= $user['avatar'] ?>)">
    </div>
    <center><b><?= $user['fio'] ?></b></center>
</div>

<div class="panel">
    <h3>Мои друзья:</h3>
    <div class="friends">
        <?php foreach($friends as $friend): ?>
        <a href="/?action=friend&f_id=<?= $friend['id'] ?>" class="avatar" style="background-image: url(<?= $friend['avatar'] ?>);" title="<?= $friend['fio'] ?>"></a>
        <?php endforeach; ?>
    </div>
</div>

<div class="panel -info">
    <table>
        <tr><td>Город:</td><td><?= $user['city'] ?></td></tr>
        <tr><td>Рабора:</td><td><?= $user['job'] ?></td></tr>
        <tr><td>Телефон:</td><td><a href="tel: <?= $user['tel'] ?>"><?= $user['tel'] ?></a></td></tr>
    </table>
</div>