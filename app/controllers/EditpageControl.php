<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class EditpageControl
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
    public function lookForm(): void
    {
        echo $this->templates->render('edit');
    }
    public function editInformation(){
        $this->qb->update('users',$_POST, $_GET['id']);
        header('Location: /users');
    }
}