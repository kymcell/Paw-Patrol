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

//grab form information to run database query
$error=false;
$date=$_POST['date'];
$query= " SELECT * FROM requests WHERE DATE_FORMAT(day, '%Y/%m/%d') = CAST('$date' AS DATE)";
$result=mysql_query($query);
$num=mysql_numrows($result);


//display database information onto the web browser
echo "
<h2><b>
  <center>Sign-Up Calendar</center>
</b></h2>
<br>
<h4><b><center>$date</center></b></h4>
<br><hr>";
$r=0;
$i=0;
while ($i < $num) {
$qvol=mysql_result($result,$i,"v_email");
$qstarttime=mysql_result($result,$i,"starttime");
$qendtime=mysql_result($result,$i,"endtime");
$qaddress=mysql_result($result,$i,"address");
$qowner=mysql_result($result,$i, "o_email");
$qid=mysql_result($result,$i, "req_id");
$qactive=mysql_result($result,$i, "r_active");
if(empty($qvol) && $qactive==0){
  $qvol="Open";
  echo "
  <form action=\"signup.php\" method=\"post\">
  <ul style=\"list-style-type: none;\">
      <li><b>$qowner</b></li>
      <li>$qvol</li>
      <li>$qstarttime-$qendtime</li>
      <li>$qaddress</li>
      <li>    <input type=\"hidden\" value=$date name=\"date\">
          <input type=\"hidden\" value=$qstarttime name=\"qstarttime\">
          <input type=\"hidden\" value=$qendtime name=\"qendtime\">
          <input type=\"hidden\" value=$qid name=\"req_id\">
      </li<
      <li><input type=\"submit\" value=\"Sign Up\"></li>
    </ul>
  </form>
  <hr>";
  $r++;
}
  $i++;
}

//displays message if the query came up empty
if($r==0){
  echo "Sorry, there are no available appointments for this day.";
}
?>
