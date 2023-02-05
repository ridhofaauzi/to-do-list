<?php

namespace App\Services\Implementation;

use App\Services\UserService;

class UserServiceImple implements UserService
{

    private array $users = [
        "ridho" => "rahasia"
    ];

    function login(string $user, string $password): bool
    {
        if (!isset($this->users[$user])) {
            return false;
        }

        $correctPassword = $this->users[$user];
        return $password = $correctPassword;
    }
}
