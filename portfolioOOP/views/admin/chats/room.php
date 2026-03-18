@extend ADMIN_CONTENT admin/main_admin

<section class="-flex">
    <h2><?= $chat->caption ?></h2>
    создан: <?= $chat->user()->getName() ?> (<?= $chat->getCreatedTime() ?>)
    <hr>
    <div>
    <?php foreach($messages as $msg): ?>
        <div class='msg'>
            <span><?= $msg->user()->getName() ?> (<?= $msg->getCreatedTime() ?>)</span>
            <p><?= $msg->getMessage() ?></p>
        </div>
    <?php endforeach; ?>
    </div>
</section>