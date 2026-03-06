@extend CONTENT main

<section>
    <?php if(isset($error)):?>
    <div class='error'><?= $error ?></div>
    <?php endif; ?>
    <form action="/admin/profile" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="uid" value="<?= $user['id'] ?>">
        <table>
            <tr>
                <td>Логин:</td>
                <td><input required autocomplete="off" name="login" value="<?= $user['login'] ?? '' ?>"></td>
            </tr>
            <tr>
                <td>Введите пароль:</td>
                <td><input autocomplete="off" type="password" name="pass"></td>
            </tr>
            <tr>
                <td>Повторите пароль:</td>
                <td><input autocomplete="off" type="password" name="pass_two"></td>
            </tr>
            <tr>
                <td>ФИО:</td>
                <td><input autocomplete="off"  name="fio" value="<?= $user['fio'] ?? '' ?>"></td>
            </tr>
            <tr>
                <td>Аватарка</td>
                <td>
                    <?php if(!empty($user['avatar'])): ?>
                        <div class="avatar" style="background-image: url(/storage/avatars/<?= $user['avatar'] ?>)"></div>
                    <?php endif; ?>
                    <input type="file" name="avatar">
                </td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td><input autocomplete="off" type="tel" name="tel" value="<?= $user['tel'] ?? '' ?>"></td>
            </tr>
            <tr>
                <td>Почта:</td>
                <td><input autocomplete="off" type="email" name="email" value="<?= $user['email'] ?? '' ?>"></td>
            </tr>
            <tr>
                <td>Телеграмм:</td>
                <td><input autocomplete="off" name="telegram" value="<?= $user['telegram'] ?? '' ?>"></td>
            </tr>
            <tr>
                <td>О себе:</td>
                <td><textarea autocomplete="off" name="desc" rows=10 cols=50><?= $user['desc'] ?? '' ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Сохранить"></td>
            </tr>
        </table>
    </form>
</section>