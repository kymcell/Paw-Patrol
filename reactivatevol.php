<?php

//define and connect datebase
define('DB_NAME', 'login');
define('DB_USER' , 'root');
define('DB_PASSWORD' , '');
define('DB_HOST' , 'localhost');
session_start();
$link=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link){
  die('Could not connect: ' .mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if(!$db_selected){
  die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

//grabs form information and runs query
$qvol=$_POST['qvol'];
$query= " UPDATE Volunteers SET v_active=0 WHERE v_email='$qvol'";
$result=mysql_query($query);
header("Location: welcomea.html");
?>
