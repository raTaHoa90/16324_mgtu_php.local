@extend CONTENT main

<style>
    .avatar {
        width: 200px;
        height: 200px;
        float: left;
        margin: 10px;
    }
</style>

<section style="min-height: 240px">
    <?php if($user['avatar']):?>
    <img class="avatar" src="/storage/avatars/<?= $user['avatar'] ?>">
    <?php endif; ?>
    <h2><?= $user['fio'] ?></h2>
    <div class="contacts">
        <?php if(isset($user['tel']) && $user['tel']): ?>
            <a href="tel:<?= $user['tel'] ?>"><i class="fa fa-mobile"></i> <?= $user['tel'] ?></a>
        <?php endif; if(isset($user['email'])): ?>
            <a href="mailto:<?= $user['email'] ?>"><i class="fa fa-envelope-o"></i> <?= $user['email'] ?></a>
        <?php endif; if(isset($user['telegram'])): ?>
            <a href="https://t.me/<?= substr($user['telegram'], 1) ?>"><i class="fa fa-telegram"></i> <?= $user['telegram'] ?></a>
        <?php endif; ?>
    </div><br>
    <?= strtr($user['desc'] ?? '', ["\n" => '<br>']) ?>
</section>

<section>
    
</section>