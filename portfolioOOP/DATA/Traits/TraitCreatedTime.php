<?php

namespace DATA\Traits;

trait TraitCreatedTime {
    function getCreatedTime(): string {
        $tm = $this->created_at;
        $pos = strpos($tm, '.');
        $tm = substr($tm, 0, $pos);
        return $tm;
    }
}