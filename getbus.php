<?php
$con = mysql_connect("localhost","root","lab228");
if (!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("relay",$con);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$break = mysql_query("SELECT name FROM ".$_POST["kv"]."bus WHERE relayset=1");
$Bus=array();
while($row=mysql_fetch_array($break)){
        array_push($Bus,$row["name"]);
}
echo json_encode($Bus);
?>
