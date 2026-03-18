<?php

namespace Controller\Admin;

use DATA\ForumThemes;
use lib\SYS;

class ChatsController extends BaseRoleAdminController {

    function index(){
        SYS::view('admin/chats/table',[
            'caption' => 'Чаты',
            'chats' => ForumThemes::all()
        ]);
    }

    function chat($params){
        $chat = ForumThemes::findBySaf($params['saf']);
        if(!$chat) 
            SYS::redirect('/admin/chats');

        SYS::view('admin/chats/room', [
            'caption' => 'Чат '.$chat->caption,
            'chat' => $chat,
            'messages' => $chat->messages()
        ]);
    }
}