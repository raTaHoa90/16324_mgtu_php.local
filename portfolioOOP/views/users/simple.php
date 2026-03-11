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
    <?php if($user->avatar):?>
    <img class="avatar" src="/storage/avatars/<?= $user->avatar ?>">
    <?php endif; ?>
    <h2><?= $user->getName() ?></h2>
    <div class="contacts">
        <?php if($user->tel): ?>
            <a href="tel:<?= $user->tel ?>"><i class="fa fa-mobile"></i> <?= $user->tel ?></a>
        <?php endif; if($user->email): ?>
            <a href="mailto:<?= $user->email ?>"><i class="fa fa-envelope-o"></i> <?= $user->email ?></a>
        <?php endif; if($user->telegram): ?>
            <a href="https://t.me/<?= substr($user->telegram, 1) ?>"><i class="fa fa-telegram"></i> <?= $user->telegram ?></a>
        <?php endif; ?>
    </div><br>
    <?= $user->getDesc() ?>
</section>

<section class="files">
    <?php foreach($catalogs as $entity): 
        if($entity['type'] == 'dir'):
    ?>
        <div class='dir'>
            <img src="/imgs/ext/dir.png"><br>
            <b><a href="?path=<?= $entity['name'] == '..' ? $topPath : $currentPath.'/'.$entity['name'] ?>"><?= $entity['name'] ?></a></b>
        </div>
    <?php else: 
        if(in_array($entity['ext'], $EXT_PIC))
            $filePic = $userpath.$entity['name'];
        else if( in_array($entity['ext'], $EXT_DOC) )
            $filePic = '/imgs/ext/icon_' + $entity['ext'] + '.png';
        else if($entity['ext'] == 'txt')
            $filePic = '/imgs/ext/icon_txt.webp';
        else 
            $filePic = "/imgs/ext/file.png";
    ?>
        <div class='file'>
            <img src="<?= $filePic ?>"><br>
            <a target="_blank" href="<?= $userpath.$entity['name'] ?>"><?= $entity['name'] ?></a>
            <div class="file-info">
                <i><?= $entity['size'] ?></i><br>
                <span><?= $entity['created_at'] ?></span>
            </div>
        </div>
    <?php endif; 
    endforeach ?>
</section>