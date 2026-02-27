@extend CONTENT main

<link rel="stylesheet" href="/css/profile.css">

<section class="-flex">
    <?php foreach($users as $user): ?>
    <div class="user" onclick="location = '/users/<?= $user['login'] ?>'">
        <h3><?= $user['fio'] ?></h3>
        <?php if(isset($user['avatar']) && $user['avatar']): ?>
        <img class="avatar" src="/storage/avatars/<?= $user['avatar'] ?>">
        <?php endif; ?>
        <div class="desc"><?= strtr($user['desc'] ?? '', ["\n"=>'<br>']) ?></div>
        <b>Контакты:</b><br>
        <?php if(isset($user['tel']) && $user['tel']): ?>
            <a href="tel:<?= $user['tel'] ?>"><i class="fa fa-mobile"></i> <?= $user['tel'] ?></a><br>
        <?php endif; if(isset($user['email'])): ?>
            <a href="mailto:<?= $user['email'] ?>"><i class="fa fa-envelope-o"></i> <?= $user['email'] ?></a><br>
        <?php endif; if(isset($user['telegram'])): ?>
            <a href="https://t.me/<?= substr($user['telegram'], 1) ?>"><i class="fa fa-telegram"></i> <?= $user['telegram'] ?></a><br>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</section>