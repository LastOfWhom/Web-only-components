<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class LoginpageControl
{
    private $qb;
    private $auth;
    private $flash;
    private $templates;
    public function __construct(QueryBuyeldier $queryBuyeldier, Engine $engine, Auth $auth)
    {
        $this->qb = $queryBuyeldier;
        $this->auth = $auth;
        $this->templates = $engine;
        $this->flash = new Flash();
    }
    public function lookForm(){

        echo $this->templates->render('page_login');

    }
    public function login(){
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            $this->flash->success(['User is logged in']);
            $_SESSION['role'] = $this->auth->getRoles();
            header('Location: /users');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error(['Wrong email address']);
            header('Location: /login');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Wrong password');
            header('Location: /login');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->flash->error(['Email not verified']);
            header('Location: /login');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error(['Too many requests']);
            header('Location: /login');
        }
    }
}