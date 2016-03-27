<?php

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;

class User extends ActiveRecord implements UserInterface
{
    public $id;
    public $email;
    public $password;
    public $role;
    public $solt;// little upgrade
    public $group_id;

    public static function getTable() {
        return 'users';
    }

    public function getRole() {
        return $this->role;
    }
}