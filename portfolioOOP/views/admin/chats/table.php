@extend ADMIN_CONTENT admin/main_admin

<section class="-flex">
    <table>
        <tr>
            <th>ID</th>
            <th>Название темы</th>
            <th>Кол-во сообщений</th>
            <th>Дата создание темы</th>
            <th>Создатель</th>
        </tr>
        <?php foreach($chats as $chat): ?> 
        <tr>
            <td><?= $chat->id ?></td>
            <td><a href="/admin/chats/<?= $chat->saf ?>"><?= $chat->caption ?></a></td>
            <td><?= $chat->countMessages() ?>
            </td>
            <td><?= $chat->getCreatedTime() ?></td>
            <td><?= $chat->user()->getName() ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>