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
$error=false;
$email=$_POST['email'];
$by=$_POST['type'];
if($by=='first'){
  $query= " SELECT * FROM Owners WHERE o_first LIKE '%{$email}%'";
}else if($by=='last'){
  $query= " SELECT * FROM Owners WHERE o_last LIKE '%{$email}%'";
}else{
  $query= " SELECT * FROM Owners WHERE o_email LIKE '%{$email}%'";
}
$result=mysql_query($query);
$num=mysql_numrows($result);

//displays query information to the browser
echo "
<h2><b>
  <center>List of Owners</center>
</b></h2>
<br><hr>";
$r=0;
$i=0;
while ($i < $num) {
$qowner=mysql_result($result,$i,"o_email");
$qfirst=mysql_result($result,$i,"o_first");
$qlast=mysql_result($result,$i,"o_last");
$qactive=mysql_result($result,$i,"o_active");
if($qactive==0){
  echo "
      <form action=\"deleteowner.php\" method=\"post\">
      <ul style=\"list-style-type: none;\">
      <li>Email: $qowner</li>
      <li>First: $qfirst</li>
      <li>Last: $qlast</li>
      <li>Active</li>
      <input type=\"hidden\" value=$qowner name=\"qowner\">
      <input type=\"hidden\" value=$qfirst name=\"qfirst\">
      <input type=\"hidden\" value=$qlast name=\"qlast\">
      <li><input type=\"submit\" value=\"Deactivate\"></li>
    </ul>
  </form>
  <hr>";
}else{
    echo "
        <form action=\"reactivateowner.php\" method=\"post\">
        <ul style=\"list-style-type: none;\">
        <li>Email: $qowner</li>
        <li>First: $qfirst</li>
        <li>Last: $qlast</li>
        <li>Deactivated</li>
        <input type=\"hidden\" value=$qowner name=\"qowner\">
        <input type=\"hidden\" value=$qfirst name=\"qfirst\">
        <input type=\"hidden\" value=$qlast name=\"qlast\">
        <li><input type=\"submit\" value=\"Reactivate\"></li>
      </ul>
    </form>
    <hr>";
}
  $r++;
  $i++;
}
if($r==0){
  echo "Sorry, couldn't find anything.";
}
?>
