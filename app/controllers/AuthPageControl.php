<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class AuthPageControl
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

    public function lookForm()
    {
        d($_SESSION);
        echo $this->templates->render('page_register', ['name' => 'Jonathan']);
    }
    public function registration()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
                echo $this->templates->render('verify_page');
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
//            die('Invalid email address');
            $this->flash->error(['Invalid email address']);
            header('Location: /auth');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error(['Invalid password']);
            header('Location: /auth');
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error(['User already exists']);
            header('Location: /auth');
//            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error(['Too many requests']);
            header('Location: /auth');
//            die('Too many requests');

        }
    }





}