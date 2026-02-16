<?php
setcookie('hasAuth', '0', 1);
setcookie('UID', 0, 1);
header('Location: '. $_SERVER['HTTP_REFERER']);

// HTTP_REFERER - ссылка с которой перешли на текущую
// REQUEST_URI - по какому пути прошел пользователь
//print_r($_SERVER);

//header('Content-Type: image/png; charset=utf-8');
//header('Set-Cookie: id=a3fWa; Max-Age=2592000', false);
//header('Set-Cookie: id2=a3fWa; Max-Age=2592000', false);

//setcookie('id','',1);