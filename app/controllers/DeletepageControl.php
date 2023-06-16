<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class DeletepageControl
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
    public function delete(){

        $home = $_SERVER['DOCUMENT_ROOT']."/";
        $resAll = $this->qb->select('users');
        $res = $resAll[ $_GET['id'] -1];
        $img = $res['img'];
        $unlink = @unlink($home.$img);

        $this->qb->delete('users', $_GET['id']);
        header('Location: /users');
    }
}