<?php

namespace App\controllers;

class Status
{
    private $status;
    public function getStatus(){

        return $this->status = [
            [
                'title' => 'online',
                'disc' => 'online'
            ],
            [
                'title' => 'away',
                'disc' => 'ofline'
            ],
            [
                'title' => 'buzy',
                'disc' => 'dont disturb'
            ]
        ];
    }
}