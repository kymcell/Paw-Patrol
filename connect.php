<?php

//defines and connects to database
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


?>
