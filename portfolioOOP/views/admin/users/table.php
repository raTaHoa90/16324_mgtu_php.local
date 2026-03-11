@extend ADMIN_CONTENT admin/main_admin

<section class="-flex">
    <table>
        <tr>
            <th>ID</th>
            <th>Логин</th>
            <th>ФИО</th>
            <th>Контакты</th>
            <th>Роль</th>
        </tr>
        <?php foreach($users as $thisUser): ?> 
        <tr xonclick="location = '/admin/users/<?= $thisUser->login ?>'">
            <td><?= $thisUser->id ?></td>
            <td><?= $thisUser->login ?></td>
            <td><?= $thisUser->fio ?></td>
            <td>
            <?php if($thisUser->tel): ?>
                <a href="tel:<?= $thisUser->tel ?>"><i class="fa fa-mobile"></i> <?= $thisUser->tel ?></a><br>
            <?php endif; if($thisUser->email): ?>
                <a href="mailto:<?= $thisUser->email ?>"><i class="fa fa-envelope-o"></i> <?= $thisUser->email ?></a><br>
            <?php endif; if($thisUser->telegram): ?>
                <a href="https://t.me/<?= substr($thisUser->telegram, 1) ?>"><i class="fa fa-telegram"></i> <?= $thisUser->telegram ?></a><br>
            <?php endif; ?>
            </td>
            <td><?= $thisUser->roleCaption() ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>