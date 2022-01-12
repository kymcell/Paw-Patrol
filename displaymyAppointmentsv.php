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
$volunteer=$_SESSION['email'];
$error=false;
$date=$_POST['date'];
$query= " SELECT * FROM requests WHERE v_email='$volunteer' AND DATE_FORMAT(day, '%Y/%m/%d') = CAST('$date' AS DATE)";
$result=mysql_query($query);
$num=mysql_numrows($result);

//displays query information to the browser
echo "
<h2><b>
  <center>My Appointments</center>
</b></h2><br>
<h4><b><center>$date</center></b></h4>
<br><hr>";
$i=0;
if($num==0){
  echo "<div>You have no appointments scheduled for this day</div>";
}else{
while ($i < $num) {
$qvol=mysql_result($result,$i,"v_email");
$qday=mysql_result($result,$i,"day");
$qstarttime=mysql_result($result,$i,"starttime");
$qendtime=mysql_result($result,$i,"endtime");
$qaddress=mysql_result($result,$i,"address");
$qowner=mysql_result($result,$i, "o_email");
echo "
  </ul>
    <ul style=\"list-style-type: none;\">
    <li>$qowner</li>
    <li>$qvol</li>
    <li>$qstarttime-$qendtime</li>
    <li>$qaddress</li>
    </ul>
    <hr>";
  $i++;
}
}
?>
