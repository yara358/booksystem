<?php

// connection to data base
$db_host = "localhost";
$db_name = "books_system";
$db_user = "root";
$db_pass = "";

// the connection 
try {
  $db_connect = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
  $db_connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db_connect -> exec("SET CHARACTER SET utf8");

} catch(Exception $e) {
  die ('Error' . $e -> GetMessage());
  echo "<div class='alert alert-danger' role='alert'>" . $e -> getLine() . "</div>";
}

// the location of the user in the calendar
date_default_timezone_set("Asia/Tel_Aviv");

// to connect the page in the localhost
define( "__LOCALHOST__", "http://127.0.0.1/bootstrap-calendar/modificado" );

// Autoload the classes 
function autoload($class) {
  include "classes/" . $class . ".php";
}

spl_autoload_register('autoload');