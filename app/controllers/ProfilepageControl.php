<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class ProfilepageControl
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
        echo $this->templates->render('page_profile');
    }
}