<?php
    $path = 'img/photos_'.$user['id'];
    if(!is_dir($path))
        mkdir($path);

    $photos = getAllPhotos();
?>

<style>
    .-fotos>*{
        width: 190px;
        height: 190px;
    }
    #imageView {
        position: relative;
        z-index: 99999;
        &>img{
            height: 90vh;
        }
        &>a.btn {
            position: absolute;
            top: 0;
            right: 0;
        }
    }
</style>

<script>
    function openImage(path){
        let dlg = document.getElementById("imageView");
        dlg.querySelector('img').src = path;
        dlg.showModal();
    }
    function closeImage(){
        document.getElementById("imageView").close();
    }
</script>

<section class="panel">
    <form action="/POST/load_photos.php" enctype="multipart/form-data" method="POST">
        <input type="file" name="photo">
        <input type="submit" value="Загрузить фотографию">
    </form>
</section>

<section class="panel">
    <h2>Мои фотографии</h2>
    <div class="flex -fotos">
        <?php foreach($photos as $photo):?>
        <a href="#i1" onclick="openImage('/<?= $path.'/'.$photo ?>')"><img src="/<?= $path.'/'.$photo ?>"></a>
        <?php endforeach; ?>
    </div>
</section>


<dialog id="imageView" closedby="any">
    <img height="100%">
    <a class="btn btn-red" onclick="closeImage()"><i class="fa fa-window-close"></i></a>
</dialog>