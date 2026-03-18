<?php

namespace DATA;

use DATA\Traits\TraitCreatedTime;
use DATA\Traits\TraitUser;
use lib\DB\DataBase;
use lib\SYS;

/*
    id serial4 NOT NULL,
	caption varchar(255) NOT NULL,
	saf varchar(255) NOT NULL,
	user_id int4 NOT NULL,
	descript text NULL,
	created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	deleted_at timestamp NULL,
*/

class ForumThemes extends Model {
    use TraitUser, TraitCreatedTime;

    static function all(): array {
        return static::allWhere("deleted_at is null ORDER BY caption");
    }

    static function findBySaf(string $saf): ?ForumThemes {
        $result = SYS::$DB->table('SELECT * FROM '.static::getTable().' WHERE deleted_at is NULL AND saf=$? LIMIT 1', [$saf], DataBase::TYPE_OBJECT, static::class);
        return $result[0] ?? null;
    }

    function setCaption(string $caption){
        $this->caption = $caption;
        $this->saf = translit($caption);
    }

    function messages(): array {
        return ForumThemeMessages::allByTheme($this->id);
    }

    function countMessages():int {
        return ForumThemeMessages::countByTheme($this->id);
    }
}