<header>
    <a href="/" > <img src="/img/logo.png" id="logo"></a>

    <?php if($isAuth): ?>
    <form action="?" method="GET">
        <input name="search">
    </form>
    <nav>
        <ul>
            <li><a href="/?action=chat" class="btn"><i class="fa fa-comment-o" aria-hidden="true"></i></a></li>
            <li><a href="/?action=profile" class="btn"><i class="fa fa-cog" aria-hidden="true"></i></a></li>
            <li><a href="/logout.php" class="btn btn-red"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
        </ul>
    </nav>
    <?php endif; ?>
</header>