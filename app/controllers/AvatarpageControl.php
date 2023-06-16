<?php

namespace App\controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class AvatarpageControl
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
        echo $this->templates->render('avatar');
    }
    public function prepareUploadrPhoto(){
        $path = pathinfo($_FILES['photo']['name']);
        $newNameFile = uniqid().'.'.$path['extension'];
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploadsImg/'.$newNameFile);
        return 'uploadsImg/'.$newNameFile;
    }
    public function uploadPhoto(){
        $imgName = $this->prepareUploadrPhoto();
        $this->qb->update('users',['img' => $imgName], $_GET['id']);
        header('Location: /avatar?id='.$_GET['id']);
    }
}