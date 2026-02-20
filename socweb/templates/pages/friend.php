<?php
    include_once "DATA/posts.php";
    if($curUser === null){
        include '404.php';
        exit;
    }

    $path = 'img/photos_'.$user['id'];
    $photos = getAllPhotos();
    $userPosts = getPostsByUser($user['id']);
?>
<link rel="stylesheet" href="/css/rss.css">

<?php if($photos): ?>
<section class="panel">
    <h2>Мои фотографии</h2>
    <div class="flex -fotos">
        <?php foreach($photos as $photo): ?>
        <a href="/<?= $path.'/'.$photo ?>" target="_blank"><img src="/<?= $path.'/'.$photo ?>"></a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if($userPosts): ?>
<section class="panel">
    <h2>Посты</h2>

    <?php foreach($userPosts as $post): ?>
    <article class="post">
        <?php if($post['img']):?>
        <div class="img" style="background-image: url(<?= $post['img'] ?>)"></div>
        <?php endif; ?>
        <span class="time"><?= $post['date'] ?></span>
        <p><?= $post['text'] ?></p>
    </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>