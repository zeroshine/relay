<?php

$con = mysql_connect("localhost","lab228","lab228");
if (!$con){
  die('Could not connect: ' . mysql_error());
}else{

}
mysql_select_db("lab228",$con);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");
function printdata(){	
 $result1= mysql_query("SELECT * FROM ".$_POST['kv']." WHERE f=\"".$_POST["first"]."\" and t=\"".$_POST["to"]."\";");
 $result2 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE t=\"".$_POST["first"]."\" and f=\"".$_POST["to"]."\";");
 if(mysql_num_rows($result1) === 1 && mysql_num_rows($result2)===0){
   $row = mysql_fetch_array($result1);
 }else if(mysql_num_rows($result1) === 0 && mysql_num_rows($result2)===1){
   $row = mysql_fetch_array($result2);
 }else{
   return;
 }
 $firstzone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["first"]."\" and t!=\"".$_POST["to"]."\") or (t=\"".$_POST["first"]."\" and f!=\"".$_POST["to"]."\");");
 $tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["to"]."\" and t!=\"".$_POST["first"]."\") or (t=\"".$_POST["to"]."\" and f!=\"".$_POST["first"]."\");");
 echo "<table border=1>";
 echo "<th>"."來端"."</th>";
 echo "<th>"."去端"."</th>";
 echo "<th>"."長度"."</th>";
 echo "<th>"."回線數"."</th>";
 echo "<th>"."正相阻抗R1"."</th>";
 echo "<th>"."正相阻抗X1"."</th>";
 echo "<th>"."零相阻抗R0"."</th>";
 echo "<th>"."零相阻抗X0"."</th>";
 echo "<th>"."正相導納B1"."</th>";
 echo "<th>"."零相導納B0"."</th>";
 echo "<th>"."零相互耦阻抗Rm0"."</th>";
 echo "<th>"."零相互耦阻抗Xm0"."</th>";
 echo "<th>"."零相互耦導納Bm0"."</th>";
 echo "<th>"."(雙)正相阻抗R1"."</th>";
 echo "<th>"."(雙)正相阻抗X1"."</th>";
 echo "<th>"."(雙)零相阻抗R0"."</th>";
 echo "<th>"."(雙)零相阻抗X0"."</th>";
 echo "<th>"."(雙)正相導納B1"."</th>";
 echo "<th>"."(雙)零相導納B0"."</th>";
 echo "<tr>";
 echo "<td>".$row['f']."</td>"."<td>".$row['t']."</td>";
 echo "<td>".$row['lenth']."</td>"."<td>".$row['ckt']."</td>"."<td>".$row['R1']."</td>"." ";
 echo "<td>".$row['X1']."</td>"."<td>".$row['R0']."</td>"."<td>".$row['X0']."</td>"."<td>".$row['B1']."</td>"."<td>".$row['B0']."</td>";
 echo "<td>".$row['RM0']."</td>"."<td>".$row['XM0']."</td>"."<td>".$row['BM0']."</td>"."<td>".$row['R1d']."</td>"."<td>".$row['X1d']."</td>";
 echo "<td>".$row['R0d']."</td>"."<td>".$row['X0d']."</td>"."<td>".$row['B1d']."</td>"."<td>".$row['B0d']."</td>";
 echo "<tr>";
 while ($row = mysql_fetch_array($firstzone1)) {
  echo "<th colspan=19 align=center> Zone1 from ".$_POST["first"]." </th>";
  echo "<tr>";
  echo "<td>".$row['f']."</td>"."<td>".$row['t']."</td>";
  echo "<td>".$row['lenth']."</td>"."<td>".$row['ckt']."</td>"."<td>".$row['R1']."</td>"." ";
  echo "<td>".$row['X1']."</td>"."<td>".$row['R0']."</td>"."<td>".$row['X0']."</td>"."<td>".$row['B1']."</td>"."<td>".$row['B0']."</td>";
  echo "<td>".$row['RM0']."</td>"."<td>".$row['XM0']."</td>"."<td>".$row['BM0']."</td>"."<td>".$row['R1d']."</td>"."<td>".$row['X1d']."</td>";
  echo "<td>".$row['R0d']."</td>"."<td>".$row['X0d']."</td>"."<td>".$row['B1d']."</td>"."<td>".$row['B0d']."</td>";
  echo "<tr>";
  $zone2start=$row['f'];
  $zone2end=$row['t'];
  if($row['f']===$_POST['first']){
    $zone2start=$row['t'];
    $zone2end=$row['f'];
  }
  echo "<th colspan = 19 align=center>"."Zone2 from ".$zone2start."</th>";
  echo "<tr>";
  $firstzone2 = mysql_query("SELECT * FROM ".$_POST['kv']." where (f=\"".$zone2start."\" and t!=\"".$zone2end."\") or (t=\"".$zone2start."\" and f!=\"".$zone2end."\");");
  while ($row2 = mysql_fetch_array($firstzone2)) {
    echo "<td>".$row2['f']."</td>"."<td>".$row2['t']."</td>";
    echo "<td>".$row2['lenth']."</td>"."<td>".$row2['ckt']."</td>"."<td>".$row2['R1']."</td>"." ";
    echo "<td>".$row2['X1']."</td>"."<td>".$row2['R0']."</td>"."<td>".$row2['X0']."</td>"."<td>".$row2['B1']."</td>"."<td>".$row2['B0']."</td>";
    echo "<td>".$row2['RM0']."</td>"."<td>".$row2['XM0']."</td>"."<td>".$row2['BM0']."</td>"."<td>".$row2['R1d']."</td>"."<td>".$row2['X1d']."</td>";
    echo "<td>".$row2['R0d']."</td>"."<td>".$row2['X0d']."</td>"."<td>".$row2['B1d']."</td>"."<td>".$row2['B0d']."</td>";
    echo "<tr>";
  }
  echo "<th colspan = 19 align=center> END </th>";
  echo "<tr>";
}
while ($row = mysql_fetch_array($tozone1)) {
  echo "<th colspan=19 align=center> Zone1 from ".$_POST["to"]." </th>";
  echo "<tr>"; 
  echo "<td>".$row['f']."</td>"."<td>".$row['t']."</td>";
  echo "<td>".$row['lenth']."</td>"."<td>".$row['ckt']."</td>"."<td>".$row['R1']."</td>"." ";
  echo "<td>".$row['X1']."</td>"."<td>".$row['R0']."</td>"."<td>".$row['X0']."</td>"."<td>".$row['B1']."</td>"."<td>".$row['B0']."</td>";
  echo "<td>".$row['RM0']."</td>"."<td>".$row['XM0']."</td>"."<td>".$row['BM0']."</td>"."<td>".$row['R1d']."</td>"."<td>".$row['X1d']."</td>";
  echo "<td>".$row['R0d']."</td>"."<td>".$row['X0d']."</td>"."<td>".$row['B1d']."</td>"."<td>".$row['B0d']."</td>";
  echo "<tr>";
  $zone2start=$row['f'];
  $zone2end=$row['t'];
  if($row['f']===$_POST['to']){
    $zone2start=$row['t'];
    $zone2end=$row['f'];
  }
  echo "<th colspan = 19 align=center>"."Zone2 from ".$zone2start."</th>";
  echo "<tr>";
  $firstzone2 = mysql_query("SELECT * FROM ".$_POST['kv']." where (f=\"".$zone2start."\" and t!=\"".$zone2end."\") or (t=\"".$zone2start."\" and f!=\"".$zone2end."\");");
  while ($row2 = mysql_fetch_array($firstzone2)) {
    echo "<td>".$row2['f']."</td>"."<td>".$row2['t']."</td>";
    echo "<td>".$row2['lenth']."</td>"."<td>".$row2['ckt']."</td>"."<td>".$row2['R1']."</td>"." ";
    echo "<td>".$row2['X1']."</td>"."<td>".$row2['R0']."</td>"."<td>".$row2['X0']."</td>"."<td>".$row2['B1']."</td>"."<td>".$row2['B0']."</td>";
    echo "<td>".$row2['RM0']."</td>"."<td>".$row2['XM0']."</td>"."<td>".$row2['BM0']."</td>"."<td>".$row2['R1d']."</td>"."<td>".$row2['X1d']."</td>";
    echo "<td>".$row2['R0d']."</td>"."<td>".$row2['X0d']."</td>"."<td>".$row2['B1d']."</td>"."<td>".$row2['B0d']."</td>";
    echo "<tr>";
  }
  echo "<th colspan = 19 align=center> END </th>";
  echo "<tr>";
}
}
if ($_POST["first"]==null){

}else{
  printdata();
}
?>
