<?php

namespace DATA\Traits;

use DATA\Users;

trait TraitUser {
    function user(): Users {
        return Users::find($this->user_id);
    }
}