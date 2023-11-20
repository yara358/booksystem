<?php require "configPDO.php";

$events = new calendar();
$events -> listToDo($db_connect);