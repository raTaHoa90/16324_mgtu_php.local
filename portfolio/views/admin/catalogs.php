@extend CONTENT main

<script src="/js/admin/catalogs.js"></script>
<script>
    catalogs.userDir = '<?= $user['id'].'_catalog' ?>';
</script>

<div class='errors'></div>

<section>
    Загрузка файла:
    <form action="/admin/catalogs/loadFile" method="POST" enctype="multipart/form-data" onsubmit="return false">
        <input type="file" name="document" id="upFile" multiple><br>
        <input type="button" value="Отправить файл в текущий каталог" onclick="catalogs.uploadFile()">
    </form>
    <br><hr>

    Создать каталог:
    <form action="/admin/catalogs/createCatalog" method="POST" onsubmit="return false">
        Имя каталога для создания: <input id="dirname" name="name" value="" placeholder="name dir" maxlength="32"> <br>
        <input type="button" value="Создать каталог" onclick="catalogs.createDir()">
    </form>
</section>

<template id="error_templ">
    <div class='error'>
        <span>ОШИБКА</span>
        <i class="fa fa-window-close-o" onclick="this.parentElement.remove();"></i>
    </div>
</template>

<template id="dir_templ">
    <div class='dir'>
        <span class="btn f-t-r" href="#" onclick="catalogs.deleteDir('#=DirName=#',this.parentElement)"><i class="fa fa-trash-o"></i></span>

        <img src="/imgs/ext/dir.png"><br>
        <b><a href="#">NameDir</a></b>
    </div>
</template>

<template id="file_templ">
    <div class='file'>
        <span class="btn f-t-r" href="#" onclick="catalogs.deleteFile('#=FileName=#',this.parentElement)"><i class="fa fa-trash-o"></i></span>

        <img src="/imgs/ext/file.png"><br>
        <a href="#">NameFile.txt</a>
        <div class="file-info">
            <i>15 kb</i><br>
            <span>12.10.2020 15:14</span>
        </div>
    </div>
</template>

<section id="pathdir"></section>

<section class="files">

</section>