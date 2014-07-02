<?php
class Cable {
    //declare variables
    var $from,$to,$length,$r1,$x1,$z1,$pre,$break,$cap;    
    var $ta=array();    
    function setCableInfo($row) {
        $this->from = $row['f'];
        $this->pre = $row['f'];
        $this->to = $row['t'];
        $this->length = $row['lenth'];
        $this->turns = $row['ckt'];
        $this->r1 = $row['R1'];
        $this->x1 = $row['X1'];
        $this->r0 = $row['R0'];
        $this->x0 = $row['X0'];
        $this->rm = $row['Rm'];
        $this->xm = $row['Xm'];
        $this->z1 = sqrt(pow($this->r1,2)+pow($this->x1,2));
        $this->z0 = sqrt(pow($this->r0,2)+pow($this->x0,2));
        $this->break=$row['break'];
        $this->cap=$row['cap'];
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
        $this->r0 =$this->r0+$obj->r0;
        $this->x0 = $this->x0+$obj->x0;
        $this->rm =$this->rm+$obj->rm;
        $this->xm = $this->xm+$obj->xm;
        $this->z1 = sqrt(pow($this->x1,2)+pow($this->r1,2));
        $this->z0 = sqrt(pow($this->x0,2)+pow($this->r0,2));
        array_push($this->ta, $this->pre);
    }
}

class Obj_json{
    var $from,$name,$Z1,$Z2,$Z3,$Zs,$Zone0Array,$MinZone0,$MaxZone0,$Zone1Array,$MinZone1,$MaxZone1,$Zone2Array,$MinZone2;
}
    
$con = mysql_connect("localhost","root","lab228");
if (!$con){
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("relay",$con);
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

function recursive($obj,&$arr,&$origin){
    //echo $obj->to." ".$origin->from."\n";
    if(substr($obj->to,0,1)!='#'){
        if($obj->to!=$origin){
            //echo $obj->to." ".$origin->from."</br>";
            array_push($arr,$obj);
        }
        return;
    }
    $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$obj->to."\" and t!=\"".$obj->pre."\") or (t=\"".$obj->to."\" and f!=\"".$obj->pre."\")) and break=1;");
    while ($row1 = mysql_fetch_array($result)){
        if($row1['f']!=$obj->to){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        if($row1['t']===$obj->pre){
            if(substr($row1['t'],0,1)!='#'){
                continue;
            }
        }
        // echo $row1["f"]." ".$row1["t"]."recursive\n";
        $zone = new Cable;
        $zone->setCableInfo($row1);
        $zone->add($obj);
        recursive($zone,$arr,$origin);
    }
}

function readData(){ 
    $break = mysql_query("SELECT * FROM ".$_POST['kv']."bus WHERE break=0");
    //echo "SELECT * FROM ".$_POST['kv']."bus WHERE break=0";
    $breakBus=array();
    while($row=mysql_fetch_array($break)){
        array_push($breakBus,$row["name"]);
    }   
    //echo "SELECT * FROM ".$_POST['kv']." WHERE f=\"".$_POST["first"]."\" or t=\"".$_POST["first"]."\" ;\n" ;
    $origin = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["first"]."\" or t=\"".$_POST["first"]."\" ) and break = 1  ;") ;
    if(mysql_num_rows($origin)===0){
        return false;
    }
    $objArray=array();
    while($row=mysql_fetch_array($origin)){
        $Zone0Array=array();
        $Zone1Array=array();
        $Zone2Array=array();
        $Zoneb1Array=array();
        $Zoneb2Array=array();
        $Z1=null;
        $Z2=null;
        $Z3=null;
        $Zs=null;        
        if($row["f"]!=$_POST['first']){
            $tmp=$row["f"];
            $row["f"]=$row["t"];
            $row["t"]=$tmp;
        }
        $back=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$_POST["first"]."\" and t!=\"".$row['t']."\") or (t=\"".$_POST["first"]."\" and f!=\"".$row['t']."\")) and break=1 ;");
        //echo "SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$_POST["first"]."\" and t!=\"".$row['t']."\") or (t=\"".$_POST["first"]."\" and f!=\"".$row['t']."\") ;\n";
        while ($backrow1=mysql_fetch_array($back)) {
            if($backrow1["f"]!=$_POST['first']){
                $tmp=$backrow1["f"];
                $backrow1["f"]=$backrow1["t"];
                $backrow1["t"]=$tmp;
            }
            $zone1b= new Cable;
            $zone1b->setCableInfo($backrow1);
            // echo $backrow1["f"]." ".$backrow1["t"]."zone1b\n";
            recursive($zone1b,$Zoneb1Array,$zone1b->from);
        }
        $MaxZoneb1=new Cable;
        if(count($Zoneb1Array)>0){
            $MaxZoneb1=$Zoneb1Array[0];
            foreach ($Zoneb1Array as $obj) {
                if($obj->z1>=$MaxZoneb1->z1){
                    $MaxZoneb1=$obj;
                }
            }
        }
        $back2=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZoneb1->to."\" and t!=\"".$MaxZoneb1->pre."\") or (t=\"".$MaxZoneb1->to."\" and f!=\"".$MaxZoneb1->pre."\")) and break=1 ;");
        if(mysql_num_rows($back2)===0 || in_array($MaxZoneb1->to,$breakBus) ){
            $back2=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZoneb1->to."\" and t=\"".$MaxZoneb1->pre."\") or (t=\"".$MaxZoneb1->to."\" and f=\"".$MaxZoneb1->pre."\")) and break=1 ;");
        }    
        while ($backrow2=mysql_fetch_array($back2)) {
            if($backrow2["f"]!=$MaxZoneb1->to){
                $tmp=$backrow2["f"];
                $backrow2["f"]=$backrow2["t"];
                $backrow2["t"]=$tmp;
            }
            $zone2b= new Cable;
            $zone2b->setCableInfo($backrow2);
            // echo "zone2b\n";
            recursive($zone2b,$Zoneb2Array,$zone2b->from);
        }
        $MaxZoneb2= new Cable;
        if(count($Zoneb2Array)>0){
            $MaxZoneb2=$Zoneb2Array[0];
            foreach ($Zoneb2Array as $obj) {
                if($obj->z1>=$MaxZoneb2->z1){
                    $MaxZoneb2=$obj;
                }                
            }
        }
        $zone0_c = new Cable;
        $zone0_c->setCableInfo($row);
        // echo $row['f']." ".$row['t']."zone0\n";
        $MaxZone0=new Cable;
        $MinZone0=new Cable;
        recursive($zone0_c,$Zone0Array,$zone0_c->from);// jump # node
        if(count($Zone0Array)>0){
            $MaxZone0=$Zone0Array[0];
            $MinZone0=$Zone0Array[0];
            foreach ($Zone0Array as $obj) {
                if($obj->z1<=$MinZone0->z1){
                    $MinZone0=$obj;
                }
                if($obj->z1>=$MaxZone0->z1){
                    $MaxZone0=$obj;
                }
            }
        }
        $tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone0->to."\" and t!=\"".$MaxZone0->pre."\") or (t=\"".$MaxZone0->to."\" and f!=\"".$MaxZone0->pre."\")) and break=1;");
        if(mysql_num_rows($tozone1)===0 || in_array($MaxZone0->to,$breakBus) ){
            //echo "SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone0->to."\" and t=\"".$MaxZone0->pre."\") or (t=\"".$MaxZone0->to."\" and f=\"".$MaxZone0->pre."\")) and break=1;\n";
            $tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone0->to."\" and t=\"".$MaxZone0->pre."\") or (t=\"".$MaxZone0->to."\" and f=\"".$MaxZone0->pre."\")) and break=1;");
            //$tozone1 = mysql_query("SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$MaxZone0->to."\" and t=\"".$MaxZone0->from."\" ) or (t=\"".$MaxZone0->to."\" and f=\"".$MaxZone0->from."\"));");
            //echo "SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$MaxZone0->to."\") or (t=\"".$MaxZone0->to."\");";
        }
        while ($row1 = mysql_fetch_array($tozone1)) {
            if($row1['f']!=$MaxZone0->to){
                $tmp=$row1['f'];
                $row1["f"]=$row1["t"];
                $row1["t"]=$tmp;
            }
            $zone1_c = new Cable;
            $zone1_c->setCableInfo($row1);
            //echo "zone1c\n";
            recursive($zone1_c,$Zone1Array,$zone1_c->from);
        }
        $MaxZone1=new Cable;
        $MinZone1=new Cable;
        if(count($Zone1Array)>0){
            $MaxZone1=$Zone1Array[0];
            $MinZone1=$Zone1Array[0];
            foreach ($Zone1Array as $obj) {
                if($obj->z1>=$MaxZone1->z1){
                    $MaxZone1=$obj;
                }
                if($obj->z1<=$MinZone1->z1){
                    $MinZone1=$obj;
                }
            }
        }
        $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone1->to."\" and t!=\"".$MaxZone1->pre."\" ) or (t=\"".$MaxZone1->to."\" and f!=\"".$MaxZone1->pre."\")) and break=1;");
        if(mysql_num_rows($result)===0 || in_array($MaxZone1->to,$breakBus)){
            $result=mysql_query("SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone1->to."\" and t=\"".$MaxZone1->pre."\" ) or (t=\"".$MaxZone1->to."\" and f=\"".$MaxZone1->pre."\")) and break=1;");
        } 
        while ($row2 = mysql_fetch_array($result)){
            if($row2['f']!=$MaxZone1->to){
                $tmp=$row2['f'];
                $row2["f"]=$row2["t"];
                $row2["t"]=$tmp;
            }
            $zone2_c = new Cable;
            $zone2_c->setCableInfo($row2);
            recursive($zone2_c,$Zone2Array,$zone2_c->from);
        }
        $MinZone2=new Cable;
        if(count($Zone2Array)>0){
            $MinZone2=$Zone2Array[0];
            foreach ($Zone2Array as $obj) {
                if($obj->z1<=$MinZone2->z1){
                    $MinZone2=$obj;
                }
            }
        }
        //$ratio_str=$_POST["ratio"];
        $ratio=(float)$_POST["ratio"];
        if($_POST['kv']=="161kv" || $_POST['kv']=="161kv_new"){
            if($MinZone0->z1>=2){
                $Z1=($MinZone0->z1*0.75)*$ratio;
            }else{
                $Z1=($MinZone0->z1*0.65)*$ratio;        
            }
            if($MinZone1->z1>=2){
                $Z2=($MaxZone0->z1+$MinZone1->z1*0.5)*$ratio;
            }else{
                $Z2=($MaxZone0->z1+$MinZone1->z1*0.6)*$ratio;
            }
            $Z3=($MaxZone0->z1+$MaxZone1->z1+$MinZone2->z1*0.25)*$ratio;
            $Zs=($MaxZoneb1->z1+$MaxZoneb2->z1)*$ratio;
        }else if($_POST['kv']=="345kv" || $_POST['kv']=="345kv_new"){
            if($MinZone0->z1>=5){
                $Z1=($MinZone0->z1*0.85)*$ratio;
            }else{
                $Z1=($MinZone0->z1*0.8)*$ratio;        
            }
            if($MinZone1->z1>=2){
                $Z2=($MaxZone0->z1+$MinZone1->z1*0.5)*$ratio;
            }else{
                $Z2=($MaxZone0->z1+$MinZone1->z1*0.6)*$ratio;
            }
            $Z3=($MaxZone0->z1+$MaxZone1->z1+$MinZone2->z1*0.25)*$ratio;
            $Zs=($MaxZoneb1->z1+$MaxZoneb2->z1)*$ratio;
        }
        $toq = mysql_query("SELECT * FROM ".$_POST['kv']."bus WHERE name=\"".$row['t']."\"");
        $fromq = mysql_query("SELECT * FROM ".$_POST['kv']."bus WHERE name=\"".$_POST["first"]."\"");
        $l3s=0;
        $l1g=0;
        $r3s=0;
        $r1g=0;
        while ($rowfrom = mysql_fetch_array($fromq)) {
            $l3s=$rowfrom['short_3'];
            $l1g=$rowfrom['ground_1'];
        }
        while ($rowto = mysql_fetch_array($toq)) {
            $r3s=$rowto['short_3'];
            $r1g=$rowto['ground_1'];
        }
        $test=0;
        $obj=new Obj_json;
        $obj->name=$row["t"];
        $obj->from=$_POST["first"];
        $obj->Zone0Array=$Zone0Array;
        $obj->MinZone0= $MinZone0;
        $obj->MaxZone0= $MaxZone0;
        $obj->Zone1Array=$Zone1Array;
        $obj->MinZone1 = $MinZone1;
        $obj->MaxZone1 = $MaxZone1;
        $obj->Zone2Array=$Zone2Array;
        $obj->MinZone2 = $MinZone2;
        $obj->Zoneb1Array=$Zoneb1Array;
        $obj->MaxZoneb1=$MaxZoneb1;
        $obj->Zoneb2Array=$Zoneb2Array;
        $obj->MaxZoneb2=$MaxZoneb2;
        $obj->Z1=$Z1;
        $obj->Z2=$Z2;
        $obj->Z3=$Z3;
        $obj->Zs=$Zs;
        $obj->l3s=$l3s;
        $obj->l1g=$l1g;
        $obj->r3s=$r3s;
        $obj->r1g=$r1g;
        $obj->cap=$MaxZone0->cap;
        array_push($objArray,$obj);
    }
    echo json_encode($objArray);
}





if ($_POST["first"]==null){

}else{
    //echo "<h1>電驛標置設定計算結果</h1>";
    readData();
}
?>
