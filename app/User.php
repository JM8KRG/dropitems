<?php

namespace DropItems;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

class User extends CartalystUser
{
    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'screen_name',
        'permissions',
    ];
}
