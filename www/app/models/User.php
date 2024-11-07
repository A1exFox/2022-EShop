<?php

namespace app\models;

class User extends AppModel
{

    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];

    public static function checkAuth(): bool
    {
        $isAuth = isset($_SESSION['user']);
        return $isAuth;
    }

    
}