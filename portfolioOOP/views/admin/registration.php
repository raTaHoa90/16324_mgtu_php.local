@extend CONTENT main

<section>
    <?php if(isset($error)):?>
    <div class='error'><?= $error ?></div>
    <?php endif; ?>
    <form action="/admin/registration" method="POST">
        <table>
            <tr>
                <td>Логин:</td>
                <td><input required autocomplete="off" name="login" value=""></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input required type="email" autocomplete="off" name="email" value=""></td>
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
                <td></td>
                <td><input type="submit" value="Сохранить"></td>
            </tr>
        </table>
    </form>
</section>