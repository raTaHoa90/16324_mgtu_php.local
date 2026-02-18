<?php
    include_once "DATA/usersFriends.php";
    $friends = getFriendsByUserID($user['id']);
?>
<link rel="stylesheet" href="/css/friends.css">

<section>
    <h2>Мои друзья</h2>

    <?php foreach($friends as $friend): ?>
    <article class="panel -frind" onclick="location='?action=friend&f_id=<?= $friend['id'] ?>'">
        <div class="img" style="background-image: url(<?= $friend['avatar'] ?>)"></div>
        <h4><?= $friend['fio'] ?></h4>
        <b>Возраст:</b> <?= $friend['age'] ?> лет
        <div class="tags">
            <a href="#" class="btn btn-light">школа</a>
            <a href="#" class="btn btn-light">лагерь</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>