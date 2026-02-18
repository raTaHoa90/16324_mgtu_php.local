<section class="panel">
    <?php if(isset($error)):?>
    <div class='error'><?= $error ?></div>
    <?php endif; ?>
    <form action="/POST/saveProfile.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="uid" value="<?= $user['id'] ?>">
        <table>
            <tr>
                <td>Логин:</td>
                <td><input required autocomplete="off" name="login" value="<?= $user['login'] ?>"></td>
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
                <td>Аватарка</td>
                <td>
                    <?php if(!empty($user['avatar'])): ?>
                        <div class="avatar" style="background-image: url(<?= $user['avatar'] ?>)"></div>
                    <?php endif; ?>
                    <input type="file" name="avatar">
                </td>
            </tr>
            <tr>
                <td>ФИО:</td>
                <td><input autocomplete="off"  name="fio" value="<?= $user['fio'] ?>"></td>
            </tr>
            <tr>
                <td>Город:</td>
                <td><input autocomplete="off" name="city" value="<?= $user['city'] ?>"></td>
            </tr>
            <tr>
                <td>Работа:</td>
                <td><input autocomplete="off" name="job" value="<?= $user['job'] ?>"></td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td><input autocomplete="off" type="tel" name="tel" value="<?= $user['tel'] ?>"></td>
            </tr>
            <tr>
                <td>Возраст:</td>
                <td><input autocomplete="off" type="number" min=10 max=150 name="age" value="<?= $user['age'] ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Сохранить"></td>
            </tr>
        </table>
    </form>
</section>