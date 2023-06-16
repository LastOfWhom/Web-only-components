<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class CreateUserpageControl
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
        echo $this->templates->render('create_user');
    }
    public function createUser(){
        $this->qb->insert('users', $_POST);
        header('Location:/users');
    }

}