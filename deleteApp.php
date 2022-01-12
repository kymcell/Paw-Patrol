<?php

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

$qid=$_POST['qid'];
$page=$_POST['page'];
$query= " UPDATE requests SET r_active=1 WHERE req_id='$qid'";
$result=mysql_query($query);
if($page==1){
  header("Location: welcome.html");
}else{
  header("Location: welcomea.html");
}
?>
