<html>
    <head>
        <title>
            Relay 
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="libs/css/bootstrap.css">
        <style type="text/css">
            .result {
                width: 80%;
                margin: 20px auto;
            }
        </style>
    </head>
    <body>
<?php
header("Content-Type:text/html; charset=utf-8");
class Cable {
    //declare variables
    var $from,$to,$length,$r1,$x1,$z1,$pre;
        
    function setCableInfo($row) {
        $this->from = $row['f'];
        $this->pre = $row['f'];
        $this->to = $row['t'];
        $this->length = $row['lenth'];
        $this->turns = $row['ckt'];
        $this->r1 = $row['R1'];
        $this->x1 = $row['X1'];
        $this->z1 = sqrt(pow($this->r1,2)+pow($this->x1,2));
    }
    
    function getCableInfo() {
        $arr = array(
            'from' => $this->from,
            'to' => $this->to,
            'length' => $this->length,
            'turns' => $this->turns,
            'r1' => $this->r1,
            'x1' => $this->x1,
            'z1' => $this->z1
        );
        return json_encode($arr);
    }
    function add($obj){
        $this->pre= $this->from;
        $this->from = $obj->from;
        $this->length = $this->length+$obj->length;
        $this->r1 =$this->r1+$obj->r1;
        $this->x1 = $this->x1+$obj->x1;
        $this->z1 = sqrt(pow($this->x1,2)+pow($this->r1,2));

    }
}


$con = mysql_connect("localhost","lab228","lab228");
if (!$con){
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("lab228",$con);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");


$MaxZone1=null;
$MinZone1=null;
$MinZone2=null;
$root =new Cable;
$Z1;
$Z2;
$Z3;

function recursive($obj,&$arr,&$origin){
    if(substr($obj->to,0,1)!='#'){
        if($obj->to!=$origin){
            //echo $obj->to." ".$origin->from."</br>";
            array_push($arr,$obj);
        }
        return;
    }
    $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$obj->to."\") or (t=\"".$obj->to."\");");
    while ($row1 = mysql_fetch_array($result)){
        if($row1['f']!=$obj->to){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        if($row1['t']===$obj->pre){
            if(substr($row2['t'],0,1)!='#'){
                continue;
            }
        }
        $zone = new Cable;
        $zone->setCableInfo($row1);
        $zone->add($obj);
        recursive($zone,$arr,$origin);
    }
}

function readData(){    
    $origin = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE f=\"".$_POST["first"]."\" or t=\"".$_POST["first"]."\" ;") ;
    if(mysql_num_rows($origin)===0){
        return false;
    }
    while($row=mysql_fetch_array($origin)){
        $Zone0Array=array();
        $Zone1Array=array();
        $Zone2Array=array();
        $MaxZone0=$Zone0Array[0];
        $MinZone0=$Zone0Array[0];
        $MaxZone1=$Zone1Array[0];
        $MinZone1=$Zone1Array[0];        
        if($row["f"]!=$_POST['first']){
            $tmp=$row["f"];
            $row["f"]=$row["t"];
            $row["t"]=$tmp;
        }
        $zone0_c = new Cable;
        $zone0_c->setCableInfo($row);
        recursive($zone0_c,$Zone0Array,$zone0_c->from);
        foreach ($Zone0Array as $obj) {
            if($obj->z1<$MinZone0->z1){
                $MinZone0=$obj;
            }
            if($obj->z1>$MaxZone0->z1){
                $MaxZone0=$obj;
            }
        }
        $tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$MaxZone0->to."\" and t!=\"".$_POST["first"]."\") or (t=\"".$MaxZone0->to."\" and f!=\"".$_POST["first"]."\");");
        while ($row1 = mysql_fetch_array($tozone1)) {
            if($row1['f']!=$MaxZone0->to){
                $tmp=$row1['f'];
                $row1["f"]=$row1["t"];
                $row1["t"]=$tmp;
            }
            $zone1_c = new Cable;
            $zone1_c->setCableInfo($row1);
            recursive($zone1_c,$Zone1Array,$zone1_c->from);
        }
        foreach ($Zone1Array as $obj) {
            if($obj->z1>$MaxZone1->z1){
                $MaxZone1=$obj;
            }
            if($obj->z1<$MinZone1->z1){
                $MinZone1=$obj;
            }
        }
    //echo "ZZZZZZZZ</br>";
        $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$MaxZone1->to."\" and t!=\"".$MaxZone1->from."\" ) or (t=\"".$MaxZone1->to."\" and f!=\"".$MaxZone1->from."\");");
        while ($row2 = mysql_fetch_array($result)){
            if($row2['f']!=$MaxZone1->to){
                $tmp=$row2['f'];
                $row2["f"]=$row2["t"];
                $row2["t"]=$tmp;
            }
            if($row2['t']===$MaxZone1->pre){
                if(substr($row2['t'],0,1)!='#'){
                    continue;
                }
            }
            $zone2_c = new Cable;
            $zone2_c->setCableInfo($row2);
            recursive($zone2_c,$Zone2Array,$zone2_c->from);
        }
        foreach ($Zone2Array as $obj) {
            if($obj->z1<$MinZone2->z1){
                $MinZone2=$obj;
            }
        }
        if($MinZone0->z1>=2){
            $Z1=($MinZone0->z1*0.75)*0.286;
        }else{
            $Z1=($MinZone0->z1*0.65)*0.286;        
        }
        if($MinZone1->z1>=2){
            $Z2=($MaxZone0->z1+$MinZone1->z1*0.5)*0.286;
        }else{
            $Z2=($MaxZone0->z1+$MinZone1->z1*0.6)*0.286;
        }
        $Z3=($MaxZone0->z1+$MaxZone1->z1+$MinZone2->z1*0.25)*0.286;
        printCable($Z1,$MinZone0,$MaxZone0,$Zone0Array,$Z2,$MinZone1,$MaxZone1,$Zone1Array,$Z3,$Zone2Array);
    }
}



function printCable($Z1,$MinZone0,$MaxZone0,$Zone0Array,$Z2,$MinZone1,$MaxZone1,$Zone1Array,$Z3,$Zone2Array){
    echo "<table border=1>";
    echo "<th>"."來端"."</th>";
    echo "<th>"."去端"."</th>";
    echo "<th>"."長度"."</th>";
    echo "<th>"."正相阻抗R1"."</th>";
    echo "<th>"."正相阻抗X1"."</th>";
    echo "<th>"."正相阻抗Z1"."</th>";
    echo "<tr>";
    echo "<th colspan=19 align=center> Zone1 </th>";
    echo "<tr>";
    foreach ($Zone0Array as $zone) {
        $root=$zone;
        echo "<td>".$root->{"from"}."</td>"."<td>".$root->{'to'}."</td>";
        echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
        echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    }
    echo "<th colspan=19 align=center> Zone2 </th>";
    echo "<tr>"; 

    foreach ($Zone1Array as $zone) {
        $root=$zone;
        echo "<td>".$root->{"from"}."</td>"."<td>".$root->{'to'}."</td>";
        echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
        echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    }

    echo "<tr>";
    echo "<th colspan=19 align=center> Zone3 </th>";
    echo "<tr>"; 
    
    foreach ($GZone2Array as $zone2) {
        $root=$zone2;
        echo "<td>".$root->{"from"}."</td>"."<td>".$root->{'to'}."</td>";
        echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
        echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    }
    echo "</table>";
    echo "<table border=1>";
    echo "<th>Z1 = (".$MinZone0->z1."* 0.75)*0.286 =".$Z1."</th></tr>";
    echo "<th>Z2 = (".$MaxZone0->z1." + ".$MinZone1->z1."*0.5)*0.286 =".$Z2."</th></tr>";
    echo "<th>Z3 = (".$MaxZone0->z1." + ".$MaxZone1->z1." + ".$MinZone2"*0.25 )*0.286 =".$Z2."</th></tr>";
    echo "</table>";
}

if ($_POST["first"]==null){

}else{
    readData();
}
?>
</body>
</html>