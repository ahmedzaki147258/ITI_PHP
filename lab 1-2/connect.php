<?php
  $dsn = "mysql:host=localhost;dbname=php_labs";
  $user = "root";
  $pass = "";
  $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");

  try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
