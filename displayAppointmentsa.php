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
$date=$_POST['date'];
$email=$_POST['email'];
if(!empty($email)){
  $query= " SELECT * FROM requests WHERE o_email = '$email' OR v_email='$email'";
}else if(!empty($date)){
  $query= " SELECT * FROM requests WHERE DATE_FORMAT(day, '%Y/%m/%d') = CAST('$date' AS DATE)";
}
$result=mysql_query($query);
$num=mysql_numrows($result);

//displays query information to the browser
echo "
<h2><b>
  <center>Appointment Calendar</center>
</b></h2>
<br><hr>";
$r=0;
$i=0;
while ($i < $num) {
  $qvol=mysql_result($result,$i,"v_email");
  $qstarttime=mysql_result($result,$i,"starttime");
  $qendtime=mysql_result($result,$i,"endtime");
  $qdate=mysql_result($result,$i,"day");
  $qaddress=mysql_result($result,$i,"address");
  $qowner=mysql_result($result,$i, "o_email");
  $qid=mysql_result($result,$i, "req_id");
  $qactive=mysql_result($result,$i, "r_active");
  if(empty($qvol))$qvol="Open";
  if($qactive==1)$qvol="Cancelled";
if($qactive==0){
  echo "
  <form action=\"deleteApp.php\" method=\"post\">
    <ul style=\"list-style-type: none;\">
        <li><b>$qowner</b></li>
        <li>$qvol</li>
        <li>$qdate</li>
        <li>$qstarttime-$qendtime</li>
        <li>$qaddress</li>
            <input type=\"hidden\" value=$qid name=\"qid\">
            <input type=\"hidden\" value=0 name=\"page\">
        </li>
        <li><input type=\"submit\" value=\"Delete\"></li>
      </ul>
    </form>
    <hr>";
    $r++;
    $i++;
  }else{
      echo "
        <ul style=\"list-style-type: none;\">
            <li><b>$qowner</b></li>
            <li>$qvol</li>
            <li>$qdate</li>
            <li>$qstarttime-$qendtime</li>
            <li>$qaddress</li>
          </ul>
        </form>
        <hr>";
        $r++;
        $i++;
  }
}
if($r==0){
  echo "Sorry, couldn't find anything.";
}
?>
