<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $caption ?? '404' ?></title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <header>
        <a href="/"><img id="logo" src="/imgs/logo.webp"></a>

        <?php if(isset($menu)): ?>
        <nav>
            <ul><?php foreach($menu as $menuItem): ?>
                <li><a class="btn" href="<?= $menuItem['url'] ?>">
                    <?php if(isset($menuItem['icon'])): ?>
                    <i class="fa <?= $menuItem['icon'] ?>"></i>
                    <?php endif ?>
                    <?= $menuItem['caption'] ?>
                </a></li>
            <?php endforeach; ?></ul>
        </nav>
        <?php endif ?>
    </header>
    <div>
        <div>
            {{CONTENT}}
        </div>
    </div>

    <footer>&copy; 2025 Все права защищены</footer>
</body>
</html>