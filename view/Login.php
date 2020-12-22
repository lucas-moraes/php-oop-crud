<?php

require_once("../controller/ControllerLoginConsult.php");

$item = new LogConsultController();

$pass = decrypt($_POST['pass']);

$arr = $item->consultItem($_POST['login'], $pass);

echo json_encode($arr);
