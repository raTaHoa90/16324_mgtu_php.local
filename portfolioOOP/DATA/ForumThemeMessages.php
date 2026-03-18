<?php

namespace DATA;

use DATA\Traits\TraitCreatedTime;
use DATA\Traits\TraitUser;

/*
    id serial4 NOT NULL,
	theme_id int4 NOT NULL,
	user_id int4 NOT NULL,
	message text NULL,
	created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	deleted_at timestamp NULL,
*/

class ForumThemeMessages extends Model {

    use TraitUser, TraitCreatedTime;

    static function allByTheme(int $themeId): array {
        return static::allWhere("theme_id = $themeId AND deleted_at is NULL ORDER BY id");
    }

    static function countByTheme(int $themeId): int {
        return static::count("theme_id = $themeId AND deleted_at is NULL");
    }

    function theme(): ForumThemes {
        return ForumThemes::find($this->theme_id);
    }

    function getMessage(){
        return strtr($this->message, ["\n"=>'<br>']);
    }

}