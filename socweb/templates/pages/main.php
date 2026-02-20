<?php
    include_once 'DATA/posts.php';
    $path = '/img/photos_'.$user['id'];
    $photos = getAllPhotos();

    $userPosts = getPostsByUser($user['id']);
?>

<link rel="stylesheet" href="/css/rss.css">

<style>
    #newPosts {
        position: relative;
        z-index: 99999;
        &>a.btn {
            position: absolute;
            top: 0;
            right: 0;
        }
    }
</style>

<script>
    function openForm(){
        let dlg = document.getElementById("newPosts");
        dlg.showModal();
    }
    function closeForm(){
        document.getElementById("newPosts").close();
    }
</script>

<?php if($photos): ?>
<section class="panel">
    <h2>Мои фотографии</h2>
    <div class="flex -fotos">
        <?php foreach($photos as $photo): ?>
        <a href="<?= $path.'/'.$photo ?>" target="_blank"><img src="<?= $path.'/'.$photo ?>"></a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section class="panel">
    <a class="btn btn-blue" style="float: right" onclick="openForm()"><i class="fa fa-plus-square"></i></a>
    <h2>Посты</h2>

    <?php foreach($userPosts as $post): ?>
    <article class="post">
        <?php if($post['img']): ?>
        <div class="img" style="background-image: url(<?= $post['img'] ?>)"></div>
        <?php endif; ?>
        <span class="time"><?= $post['date'] ?></span>
        <p><?= strtr($post['text'], ["\n"=>'</p><p>']) ?></p>
    </article>
    <?php endforeach; ?>
</section>

<dialog id="newPosts" closedby="any">
    <form action="/POST/newPost.php" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Картинка поста:</td>
                <td><input type="file" name="postImage"></td>
            </tr>
            <tr>
                <td>Текст поста:</td>
                <td><textarea name="msg" rows=40 cols=60></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Сохранить"></td>
            </tr>
        </table>
    </form>
    <a class="btn btn-red" onclick="closeForm()"><i class="fa fa-window-close"></i></a>
</dialog>