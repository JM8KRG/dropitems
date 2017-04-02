<?php

namespace DropItems\Utils;

use Sentinel;

class UserUtil
{
    protected $user;

    public static function getUser()
    {
        return Sentinel::getUser();
    }
}