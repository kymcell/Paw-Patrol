<?php

//defines and connects database
define('DB_NAME', 'login');
define('DB_USER' , 'root');
define('DB_PASSWORD' , '');
define('DB_HOST' , 'localhost');
$link=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link){
	die('Could not connect: ' .mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if(!$db_selected){
	die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

//grab information from form
$error=false;
$type=$_POST['type'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$first=$_POST['first'];
$last=$_POST['last'];
$phone=$_POST['phone'];
$count=0;

//checks input for valid inputs
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$error = true;
	$errorM = "Invalid email format";
}else{
	if($type == "Volunteer"){
			$query = "SELECT v_email FROM volunteers WHERE v_email='$email'";
		  $result = mysql_query($query);
		  $count = mysql_num_rows($result);
	}elseif($type == "Owner"){
		$query = "SELECT o_email FROM onwers WHERE o_email='$email'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
	}
	if($count!=0){
		$error = true;
		$errorM = "Email is already in use.";
	}
}

//displays appropraite error message for missing/invalid info
if(empty($pass)){
	$error=true;
	$errorM="Please enter a password.";
}
if(empty($first)){
	$error=true;
	$errorM="Please enter your first name.";
}
if(empty($last)){
	$error=true;
	$errorM="Please enter your last name.";
}
if(empty($phone)){
	$error=true;
	$errorM="Please enter your phone number.";
}

//inserts users signin information into the database
if(!$error){
	if($type=="Volunteer"){
		$query = "INSERT INTO volunteers (v_email,v_pass,v_first,v_last,v_phone_number) VALUES ('$email', '$pass', '$first', '$last', '$phone')";
		if(!mysql_query($query)){
			die('Error: ' . mysql_error());
		}
		header("Location: signIn.html");
	}elseif ($type=="Owner") {
		$query = "INSERT INTO owners (o_email,o_pass,o_first,o_last,o_phone_number) VALUES ('$email', '$pass', '$first', '$last', '$phone')";
		if(!mysql_query($query)){
			die('Error: ' . mysql_error());
		}
		header("Location: signIn.html");
	}
}else{//displays error if there is an error
	echo "<script type='text/javascript'>alert('$errorM');
    window.location.href='register.html';  </script>";

}

mysql_close();

?>
