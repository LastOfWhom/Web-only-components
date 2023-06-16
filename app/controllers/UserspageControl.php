<?php

namespace App\controllers;

use League\Plates\Engine;

class UserspageControl
{
    private $qb;
    private $templates;
    public function __construct(QueryBuyeldier $queryBuyeldier, Engine $engine){
        $this->qb = $queryBuyeldier;
        $this->templates = $engine;
    }
    public function get(){
        $resultAllPosts = $this->qb->select('users');
        echo $this->templates->render('users', ['posts' => $resultAllPosts]);
    }
}