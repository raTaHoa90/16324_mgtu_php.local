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
            <?php if($user->tel): ?>
                <a href="tel:<?= $user->tel ?>"><i class="fa fa-mobile"></i> <?= $user->tel ?></a><br>
            <?php endif; if($user->email): ?>
                <a href="mailto:<?= $user->email ?>"><i class="fa fa-envelope-o"></i> <?= $user->email ?></a><br>
            <?php endif; if($user->telegram): ?>
                <a href="https://t.me/<?= substr($user->telegram, 1) ?>"><i class="fa fa-telegram"></i> <?= $user->telegram ?></a><br>
            <?php endif; ?>
            </td>
            <td><?= $user->roleCaption() ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>