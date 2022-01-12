<?php

//defines and connects database
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

//grabs form information and checks if there are conflicting signup times
$qstarttime=$_POST['qstarttime'];
$qendtime=$_POST['qendtime'];
$date=$_POST['date'];
$email=$_SESSION['email'];
$query= "SELECT * FROM (SELECT * FROM `requests` WHERE day=CAST('$date' AS DATE) AND v_email='$email') as i WHERE CAST('$qstarttime' AS TIME) BETWEEN starttime AND endtime OR CAST('$qendtime' AS TIME) BETWEEN starttime AND endtime;";
$result=mysql_query($query);
$num=mysql_numrows($result);

//displays error if they are already busy or successful updates database
if($num>0){
  $errorM="Sorry, but you are already busy for this time.";
  echo "<script type='text/javascript'>alert('$errorM');
  window.location.href='welcomev.html'; </script>";
}else{
$error=false;
$qid=$_POST['req_id'];
$query= " UPDATE requests SET v_email='$email' WHERE req_id='$qid'";
$result=mysql_query($query);
header("Location: welcomev.html");
}
?>
