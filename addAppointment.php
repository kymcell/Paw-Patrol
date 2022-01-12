<?php

//database defining
define('DB_NAME', 'login');
define('DB_USER' , 'root');
define('DB_PASSWORD' , '');
define('DB_HOST' , 'localhost');

//start session for user
session_start();

//connect database
$link=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link){
	die('Could not connect: ' .mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if(!$db_selected){
	die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

//get the variables from the form
$day=$_POST['date'];
$starttime=$_POST['start'];
$endtime=$_POST['end'];
$address=$_POST['address'];
$error=false;

//checks if any of the fields are empty
if(empty($day)){
	$error=true;
	$errorM="Please enter a day.";
}
if(empty($starttime)){
	$error=true;
	$errorM="Please enter a start time.";
}
if(empty($endtime)){
	$error=true;
	$errorM="Please enter a end time.";
}
if(empty($address)){
	$error=true;
	$errorM="Please enter a address.";
}

//grab email from seesion
$creator=$_SESSION['email'];

//grabs database information and sends user to welcome page
if(!$error){
$query = "INSERT INTO requests (day,starttime,endtime,address,o_email) VALUES ('$day','$starttime', '$endtime', '$address', '$creator')";
	if(!mysql_query($query)){
		die('Error: ' . mysql_error());
	}
	header("Location: welcome.html");
}else{
	echo "<script type='text/javascript'>alert('$errorM');
		window.location.href='addSched.html'; </script>";

}

mysql_close();

?>
