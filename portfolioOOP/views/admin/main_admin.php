@extend CONTENT main

<div style="position: absolute; top: 20px; right: 10px">
    <?= $user->getName() ?> (<?= $user->roleCaption() ?>)
</div>

{{ADMIN_CONTENT}}