<?php
$name = $_POST['fname'];
$rno = $_POST['id'];

$con = mysql_connect("localhost","root","");
$db= mysql_select_db("school", $con);
$sql = "SELECT address from students where name='".$name."' AND rno=".$rno;
$result = mysql_query($sql,$con);
$row=mysql_fetch_array($result);
echo $row['address'];
?>