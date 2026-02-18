<?php
include_once 'users.php';
$usersFriends = json_decode(file_get_contents('DATA/usersFriends.json'), true);

/*
    user_one_id:
    user_two_id:
*/

function getFriendsByUserID(int $id): ?array {
    global $usersFriends;
    $result = [];
    foreach($usersFriends as $userFr)
        if($userFr['user_one_id'] == $id)
            $result[] = $userFr['user_two_id'];
        elseif($userFr['user_two_id'] == $id)
            $result[] = $userFr['user_one_id'];

    if(count($result) > 0)
        foreach($result as &$res)
            $res = getUserById($res);

    return $result;
}