<?php
$posts = json_decode(file_get_contents('DATA/posts.json'), true);
/*
    userID: ID пользователя, который отправил сообщение
    img: ссфлка на картинку или пустая строка
    date: время сообщения в формате "день/месяц/год"
    text: текст сообщения
*/


function getPostsByUser(int $uid): array {
    global $posts;
    $result = array_filter($posts, fn($post) => $post['userID'] == $uid);
    usort($result, fn($a, $b)=> strtotime($a['date']) <=> strtotime($b['date']));
    return $result;
}

function savePostData(int $uid, string $pathFile, string $message){
    global $posts;
    $posts[] = [
        'userID' => $uid,
        'date' => date('d/m/Y'),
        'img' => $pathFile,
        'text' => $message
    ];

    file_put_contents('DATA/posts.json', json_encode($posts));
}