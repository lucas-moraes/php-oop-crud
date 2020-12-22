<?php
require_once("../model/login.php");

class LogConsultController
{
    public $item;

    public function __construct()
    {
        $this->item = new LogConsult();
    }

    public function consultItem($login, $pass)
    {
        return $this->item->consult($login, $pass);
    }
}
