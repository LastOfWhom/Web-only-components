<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class VerifypageControl
{
    private $qb;
    private $auth;
    private $templates;
    private $flash;

    public function __construct(QueryBuyeldier $queryBuyeldier, Auth $auth, Engine $engine)
    {
        $this->qb = $queryBuyeldier;
        $this->auth = $auth;
        $this->templates = $engine;
        $this->flash = new Flash();
    }
    public function verify(){
        echo $this->templates->render('verify_page');
    }

    public function verifyEmail(){
        try {
            d(123);die;
            $this->auth->confirmEmail($_POST['selector'], $_POST['token']);

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}