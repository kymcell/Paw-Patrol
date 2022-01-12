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

//grabs form information and runs query depending on which type of account it is
$error=false;
$type=$_POST['type'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$count=0;
if($type=="Volunteer"){
  $query= " SELECT * FROM volunteers WHERE v_email='$email' && v_pass='$pass' && v_active=0";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res);
  $count = mysql_num_rows($res);
}elseif ($type=="Owner") {
  $query= " SELECT * FROM owners WHERE o_email='$email' && o_pass='$pass' && o_active=0";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res);
  $count = mysql_num_rows($res);
}elseif ($type=="Admin") {
  $query= " SELECT * FROM admin WHERE a_email='$email' && a_pass='$pass'";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res);
  $count = mysql_num_rows($res);
}

//if the query isnt empty, or their account info matches, sends them to the welcome
if ($count > 0) {
  $_SESSION['email']=$email;
  $_SESSION['type']=$type;
  if($type=="Volunteer"){
    header("Location: welcomev.html");
  }else if ($type=="Admin"){
    header("Location: welcomea.html");
  }else{
     header("Location: welcome.html");
  }
  exit;
}else{//errors if the account doesn't exist or password/type arent correct
   $errorM="Your username, password or type is incorrect. Please try again. ";
  echo "<script type='text/javascript'>alert('$errorM');
    window.location.href='signIn.html'; </script>";
}﻿
?>
