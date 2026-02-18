<?php include_once 'DATA/chat.php'; ?>
<link rel="stylesheet" href="/css/chat.css">

<section>
    <div class="panel">
        <div id="room">
            <?php foreach($chatMessages as $message): 
                $curUser = getUserById($message['userID']);
            ?>
            <div class="msg <?= $user['id'] == $curUser['id'] ? '-my' : '' ?>">
                <div class="img" style="background-image: url(<?= $curUser['avatar'] ?>)"></div>
                <div class="-top"><b><?= $curUser['fio'] ?></b>
                    <small><?= $message['date'] ?></small>
                </div>
                <div class="text"><?= $message['message'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="panel form-send">
        <form action="/POST/sendChat.php" method="post">
            <input type="hidden" name="rid" value="">
            <textarea name="msg" rows=10 cols=60></textarea><br>
            <input type="submit" value="Отправить">
        </form>
    </div>
</section>