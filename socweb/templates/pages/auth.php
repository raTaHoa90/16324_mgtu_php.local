<section class="panel">
    <?php if(isset($error)):?>
    <div class='error'><?= $error ?></div>
    <?php endif; ?>
    <form action="/POST/auth.php" method="POST">
        <table>
            <tr>
                <td class="-ta-r">Ваш логин:</td>
                <td><input name="login" placeholder="exsample"></td>
            </tr>
            <tr>
                <td class="-ta-r">Пароль:</td>
                <td><input name="pass" type="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Войти"></td>
            </tr>
        </table>
    </form>
</section>