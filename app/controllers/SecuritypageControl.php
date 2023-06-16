<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class SecuritypageControl
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

        if(isset($_SESSION['flash_messages'])){
            $state =  $this->flash->display();
        }
        echo $this->templates->render('security', ['state' => $state]);
    }
    public function changePass(){
        if($_SESSION['role']['1'] != 'ADMIN'){
            try {
                $this->auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);
                $this->flash->success('Пароль обновлен');
                header('Location: /security');
                exit;

            }
            catch (\Delight\Auth\NotLoggedInException $e) {
                $this->flash->error('Not logged in');
                header('Location: /security');
                exit;
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                $this->flash->error('Invalid password(s)');
                header('Location: /security');
                exit;
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                $this->flash->error('Too many requests');
                header('Location: /security');
                exit;
            }
        }
        try {
            $this->auth->admin()->changePasswordForUserById($_GET['id'], $_POST['newPassword']);
            $this->flash->success('Пароль обновлен');
            header('Location: /security?id='.$_GET['id']);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown ID');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }


    }
}