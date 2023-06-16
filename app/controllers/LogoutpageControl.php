<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class LogoutpageControl
{

    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    public function logout(){
        try {
            $this->auth->logOut();
            $this->auth->destroySession();
            header('Location: /');
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
    }
}