<?php

namespace App\controllers;

use Couchbase\Group;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class StatuspageControl
{
    private $qb;
    private $auth;
    private $flash;
    private $templates;
    private $status;

    public function __construct(QueryBuyeldier $queryBuyeldier, Engine $engine, Auth $auth, Status $status)
    {
        $this->qb = $queryBuyeldier;
        $this->auth = $auth;
        $this->templates = $engine;
        $this->flash = new Flash();
        $this->status = $status;
    }

    public function changeStatus(){
        $this->qb->update('users',$_POST, $_GET['id']);
        header('Location: /status?id='.$_GET['id']);
    }
    public function lookForm(){
        $result = $this->qb->select('users');
        $id = $this->auth->getUserId();
        $currentStatus = $result[$id - 1]['userStatus'];
        echo $this->templates->render('status', ['status' => $this->status->getStatus(), 'currentStatus' => $currentStatus]);
    }


}