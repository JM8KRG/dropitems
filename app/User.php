<?php

namespace DropItems;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'screen_name',
        'permissions',
    ];

    /**
     * Array of  login column names.
     *
     * @var array
     */
    protected $loginNames = ['screen_name', 'email'];
//
//    /**
//     * ユーザーのスクリーンネームを取得する
//     *
//     * @return null|string
//     */
//    public function getUserScreenName()
//    {
//        return $this->screen_name;
//    }
//
//    /**
//     * ユーザーのメールアドレスを取得する
//     *
//     * @return null|string
//     */
//    public function getUserEmail()
//    {
//        return $this->email;
//    }
//
//    /**
//     * ユーザーの名を取得する
//     *
//     * @return null|string
//     */
//    public function getUserFirstName()
//    {
//        return $this->first_name;
//    }
//
//    /**
//     * ユーザーの姓を取得する
//     *
//     * @return null|string
//     */
//    public function getUserLastName()
//    {
//        return $this->last_name;
//    }
}
