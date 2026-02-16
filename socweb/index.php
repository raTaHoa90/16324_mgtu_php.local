<?php
    if(isset($_REQUEST['error']))
        $error = $_REQUEST['error'];

    $action = $_GET['action'] ?? 'main';
    if(! file_exists("templates/pages/$action.php")){
        $action = '404';
        http_response_code(404);
    }
    $isAuth = isset($_COOKIE['hasAuth']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body class="-grid-page">
    <?php include "templates/header.php"; ?>

    <aside id="left">
        <?php
            if($isAuth)
                include "templates/menu.php"; 
        ?>
    </aside>

    <div id="contents">
        <?php 
            if($isAuth)
                include "templates/pages/$action.php"; 
            else 
                include "templates/pages/auth.php"; 
        ?>
    </div>

    <aside id="right">
        <?php 
            if($isAuth)
                include "templates/aside.php"; 
        ?>
    </aside>

    <footer>&copy; 2026 г. Все права защищены.</footer>
</body>
</html>