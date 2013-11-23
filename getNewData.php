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

$Zone1Array=array();
$Zone2Array=array();
$root =new Cable;

function recursive($obj,&$arr){
    if(substr($obj->to,0,1)!='#'){
        array_push($arr,$obj);
        return;
    }
    $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$obj->to."\" and t!=\"".$obj->from."\") or (t=\"".$obj->to."\" and f!=\"".$obj->from."\");");
    while ($row1 = mysql_fetch_array($result)){
        if($row1['f']!=$obj->to){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        //echo "while";
        $zone = new Cable;
        $zone->setCableInfo($row1);
        $zone->add($obj);
        recursive($zone,$arr);
    }
}

function readData(){    
    $origin = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["to"]."\" and t=\"".$_POST["first"]."\") or (t=\"".$_POST["to"]."\" and f=\"".$_POST["first"]."\");");
    //$result1= mysql_query("SELECT * FROM ".$_POST['kv']." WHERE f=\"".$_POST["first"]."\" and t=\"".$_POST["to"]."\";");
    //$result2 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE t=\"".$_POST["first"]."\" and f=\"".$_POST["to"]."\";");
    if(mysql_num_rows($origin)===0){
        echo "cable Not found";
        return false;
    }
    $row=mysql_fetch_array($origin);
    if($row["f"]!=$_POST['first']){
        $tmp=$row["f"];
        $row["f"]=$row["t"];
        $row["t"]=$tmp;
    }
    //echo $row[""];
    //$GLOBALS['variable'] = something;
    $GLOBALS["root"]->setCableInfo($row);
    $tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["to"]."\" and t!=\"".$_POST["first"]."\") or (t=\"".$_POST["to"]."\" and f!=\"".$_POST["first"]."\");");
    while ($row1 = mysql_fetch_array($tozone1)) {
        if($row1['f']!=$_POST["to"]){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        $zone1_c = new Cable;
        $zone1_c->setCableInfo($row1);
        recursive($zone1_c,$GLOBALS['Zone1Array']);
    }
    foreach ($GLOBALS["Zone1Array"] as $obj) {
        $tozone2 = mysql_query("SELECT * FROM ".$_POST['kv']." where (f=\"".$obj->to."\" and t!=\"".$obj->pre."\") or (t=\"".$obj->to."\" and f!=\"".$obj->pre."\");");
        while ($row2 = mysql_fetch_array($tozone2)) {
            if($row2['f']!=$obj->to){
                $tmp=$row2['f'];
                $row2["f"]=$row2["t"];
                $row2["t"]=$tmp;
            }
            $zone2_c = new Cable;
            $zone2_c->setCableInfo($row2);
            recursive($zone2_c,$GLOBALS['Zone2Array']);
        }
    }
}

function printCable(){
    echo "<table border=1>";
    echo "<th>"."來端"."</th>";
    echo "<th>"."去端"."</th>";
    echo "<th>"."長度"."</th>";
    echo "<th>"."正相阻抗R1"."</th>";
    echo "<th>"."正相阻抗X1"."</th>";
    echo "<th>"."正相阻抗Z1"."</th>";
    echo "<tr>";
    $root=json_decode($GLOBALS["root"]->getCableInfo());
    echo "<td>".$_POST["first"]."</td>"."<td>".$_POST['to']."</td>";
    echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
    echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    echo "<th colspan=19 align=center> Zone1 </th>";
    echo "<tr>"; 

    foreach ($GLOBALS["Zone1Array"] as $zone) {
        $root=$zone;
        echo "<td>".$root->{"from"}."</td>"."<td>".$root->{'to'}."</td>";
        echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
        echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    }

    echo "<tr>";
    echo "<th colspan=19 align=center> Zone2 </th>";
    echo "<tr>"; 
    
    foreach ($GLOBALS["Zone2Array"] as $zone2) {
        $root=$zone2;
        echo "<td>".$root->{"from"}."</td>"."<td>".$root->{'to'}."</td>";
        echo "<td>".$root->{"length"}."</td>"."<td>".$root->{'r1'}."</td>"." ";
        echo "<td>".$root->{'x1'}."</td><td>".$root->{'z1'}."</td><tr>";
    }


}

if ($_POST["first"]==null){

}else{
    readData();
    printCable();
}
?>
