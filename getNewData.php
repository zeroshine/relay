<?php
class Cable {
    //declare variables
    var $id,$fid,$from,$tid,$to,$lineid,$length,$r1,$x1,$z1,$pre,$break,$cap;    
    var $ta=array();    
    function setCableInfo($row) {//set the information of cable
        $this->id=$row["id"];
        $this->from = $row['f'];
        $this->fid=$row['fid'];
        $this->pre = $row['f'];
        $this->tid = $row['tid'];
        $this->to = $row['t'];
        $this->lineid= $row['lineid'];
        $this->length = $row['length'];
        $this->r1 = $row['R1'];
        $this->x1 = $row['X1'];
        $this->r0 = $row['R0'];
        $this->x0 = $row['X0'];
        $this->z1 = sqrt(pow($this->r1,2)+pow($this->x1,2));
        $this->z0 = sqrt(pow($this->r0,2)+pow($this->x0,2));
        $this->break=$row['break'];
        $this->cap=$row['cap'];
    }
    function add($obj){// add new cable when  jump to tap point
        $this->pre= $this->from;
        $this->from = $obj->from;
        $this->length = $this->length+$obj->length;
        $this->r1 =$this->r1+$obj->r1;
        $this->x1 = $this->x1+$obj->x1;
        $this->r0 =$this->r0+$obj->r0;
        $this->x0 = $this->x0+$obj->x0;
        $this->z1 = sqrt(pow($this->x1,2)+pow($this->r1,2));
        $this->z0 = sqrt(pow($this->x0,2)+pow($this->r0,2));
        if($this->cap>$obj->cap){
            $this->cap=$obj->cap;
        }
        array_push($this->ta, $this->pre);
    }
}

class Obj_json{
    var $from,$name,$Z1,$Z2,$Z3,$Zs,$Zone0Array,$MinZone0,$MaxZone0,$Zone1Array,$MinZone1,$MaxZone1,$Zone2Array,$MinZone2,$lineid;
}
    
$con = mysqli_connect("localhost","relay","lab228","relay");
if (!$con){
    die('Could not connect: ' . mysqli_error());
}
mysqli_query($con,"SET NAMES 'utf8'"); 
mysqli_query($con,"SET CHARACTER_SET_CLIENT=utf8"); 
mysqli_query($con,"SET CHARACTER_SET_RESULTS=utf8");

function recursive($obj,&$arr,&$origin){
    if(substr($obj->to,-2,-1)!='#' ||substr($obj->to,-3,-2)!='#'){
            array_push($arr,$obj);
        return;
    }
    $result=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$obj->to."\" and id!=\"".$obj->id."\" ) 
        or (t=\"".$obj->to."\" and id!=\"".$obj->id."\")) and break=1;");
    while ($row1 = mysqli_fetch_array($result)){
        if($row1['f']!=$obj->to){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        if($row1['t']===$obj->pre){
            if(substr($row1['t'],0,-2)!='#'){
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
    $con = mysqli_connect("localhost","relay","lab228","relay");//connect to sql
    if (!$con){
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con,"SET NAMES 'utf8'"); 
    mysqli_query($con,"SET CHARACTER_SET_CLIENT=utf8"); 
    mysqli_query($con,"SET CHARACTER_SET_RESULTS=utf8");
    $break = mysqli_query($con,"SELECT * FROM ".$_POST['kv']."bus WHERE break=0");
    $breakBus=array();
    while($row=mysqli_fetch_array($break)){
        array_push($breakBus,$row["name"]);
    }//find the breakbus
    $test="SELECT * FROM ".$_POST["kv"]." WHERE (f=\"".$_POST["first"]."\" or t=\"".$_POST["first"]."\" ) and break = 1  ;";
    $origin = mysqli_query($con,$test) ;//select the origin zone1 bus from database
    if(mysqli_num_rows($origin)===0){
        return false;
    }
    $objArray=array();
    while($row=mysqli_fetch_array($origin)){
        $Zone0Array=array();
        $Zone1Array=array();
        $Zone2Array=array();
        $Zoneb1Array=array();
        $Zoneb2Array=array();
        $Z1=null;
        $Z2=null;
        $Z3=null;
        $Zs=null;        
        if($row["f"]!=$_POST['first']){//let cable from-end is the same  
            $tmp=$row["f"];
            $row["f"]=$row["t"];
            $row["t"]=$tmp;
        }
        $back=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$_POST["first"]."\" and id!=\"".$row['id']."\") 
            or (t=\"".$_POST["first"]."\" and id!=\"".$row['id']."\")) and break=1 ;");
        while ($backrow1=mysqli_fetch_array($back)) {//find the back1 zone in database
            if($backrow1["f"]!=$_POST['first']){
                $tmp=$backrow1["f"];
                $backrow1["f"]=$backrow1["t"];
                $backrow1["t"]=$tmp;
            }
            $zone1b= new Cable;
            $zone1b->setCableInfo($backrow1);
            recursive($zone1b,$Zoneb1Array,$zone1b->from);//jump the tap and Zoneb1array is the result
        }
        $MaxZoneb1=new Cable;
        if(count($Zoneb1Array)>0){
            $MaxZoneb1=$Zoneb1Array[0];
            foreach ($Zoneb1Array as $obj) {//find the max in zoneb1array
                if($obj->z1>=$MaxZoneb1->z1){
                    $MaxZoneb1=$obj;
                }
            }
        }
        $back2=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZoneb1->to."\" and id !=\"".$MaxZoneb1->id."\") 
            or (t=\"".$MaxZoneb1->to."\" and f!=\"".$MaxZoneb1->pre."\" and lineid !=\"".$MaxZoneb1->lineid."\")) and break=1 ;");
        if(mysqli_num_rows($back2)===0 || in_array($MaxZoneb1->to,$breakBus) ){
            $back2=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZoneb1->to."\" and t=\"".$MaxZoneb1->pre."\" ) 
                or (t=\"".$MaxZoneb1->to."\" and f=\"".$MaxZoneb1->pre."\" )) and break=1 ;");
        }//find the back2zone in database    
        while ($backrow2=mysqli_fetch_array($back2)) {
            if($backrow2["f"]!=$MaxZoneb1->to){//let cables from-end are the same 
                $tmp=$backrow2["f"];
                $backrow2["f"]=$backrow2["t"];
                $backrow2["t"]=$tmp;
            }
            $zone2b= new Cable;
            $zone2b->setCableInfo($backrow2);
            recursive($zone2b,$Zoneb2Array,$zone2b->from);//jump tap point and zoneb2array is the result
        }
        $MaxZoneb2= new Cable;
        if(count($Zoneb2Array)>0){
            $MaxZoneb2=$Zoneb2Array[0];
            foreach ($Zoneb2Array as $obj) { //find the max the zoneb2array
                if($obj->z1>=$MaxZoneb2->z1){
                    $MaxZoneb2=$obj;
                }                
            }
        }
        $zone0_c = new Cable;
        $zone0_c->setCableInfo($row);
        $MaxZone0=new Cable;
        $MinZone0=new Cable;
        recursive($zone0_c,$Zone0Array,$zone0_c->from);// jump tap point and zone0array is the result
        if(count($Zone0Array)>0){
            $MaxZone0=$Zone0Array[0];
            $MinZone0=$Zone0Array[0];
            foreach ($Zone0Array as $obj) {//
                if($obj->z1<=$MinZone0->z1){
                    $MinZone0=$obj;
                }
                if($obj->z1>=$MaxZone0->z1){
                    $MaxZone0=$obj;
                }
            }
        }
        $tozone1 = mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone0->to."\" and id !=\"".$MaxZoneb1->lineid."\") 
            or (t=\"".$MaxZone0->to."\" and id !=\"".$MaxZone0->id."\")) and break=1;");
        if(mysqli_num_rows($tozone1)===0 || in_array($MaxZone0->to,$breakBus) ){
            $tozone1 = mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone0->to."\" and t=\"".$MaxZone0->pre."\") 
                or (t=\"".$MaxZone0->to."\" and f=\"".$MaxZone0->pre."\"  )) and break=1;");
        }//find the zone1 in database
        while ($row1 = mysqli_fetch_array($tozone1)) {
            if($row1['f']!=$MaxZone0->to){//let cables from-end are the same
                $tmp=$row1['f'];
                $row1["f"]=$row1["t"];
                $row1["t"]=$tmp;
            }
            $zone1_c = new Cable;
            $zone1_c->setCableInfo($row1);
            recursive($zone1_c,$Zone1Array,$zone1_c->from);//jump tap point and the result is in zone1array
        }
        $MaxZone1=new Cable;
        $MinZone1=new Cable;
        if(count($Zone1Array)>0){
            $MaxZone1=$Zone1Array[0];
            $MinZone1=$Zone1Array[0];
            foreach ($Zone1Array as $obj) {
                if($obj->z1>=$MaxZone1->z1){//find the max zone1
                    $MaxZone1=$obj;
                }
                if($obj->z1<=$MinZone1->z1){//find the min zone1
                    $MinZone1=$obj;
                }
            }
        }
        $result=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone1->to."\" and id !=\"".$MaxZone1->id."\" ) 
            or (t=\"".$MaxZone1->to."\" and id !=\"".$MaxZone1->id."\" )) and break=1;");
        if(mysqli_num_rows($result)===0 || in_array($MaxZone1->to,$breakBus)){
            $result=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$MaxZone1->to."\" and t=\"".$MaxZone1->pre."\"  ) 
                or (t=\"".$MaxZone1->to."\" and f=\"".$MaxZone1->pre."\")) and break=1;");
        }//find the zone2 in database 
        while ($row2 = mysqli_fetch_array($result)){
            if($row2['f']!=$MaxZone1->to){//let cables from-end are the same
                $tmp=$row2['f'];
                $row2["f"]=$row2["t"];
                $row2["t"]=$tmp;
            }
            $zone2_c = new Cable;
            $zone2_c->setCableInfo($row2);
            recursive($zone2_c,$Zone2Array,$zone2_c->from);//jump tap point and the result are stored in zone2array
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
        $ratio=(float)$_POST["ratio"];
        if($_POST['kv']=="161kv" || $_POST['kv']=="161kv_new"){//compute the z1 z2 z3 zs
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
        $toq = mysqli_query($con,"SELECT * FROM ".$_POST['kv']."bus WHERE name=\"".$row['t']."\"");
        $fromq = mysqli_query($con,"SELECT * FROM ".$_POST['kv']."bus WHERE name=\"".$_POST["first"]."\"");
        $l3s=0;
        $l1g=0;
        $r3s=0;
        $r1g=0;
        while ($rowfrom = mysqli_fetch_array($fromq)) {
            $l3s=$rowfrom['short_3'];
            $l1g=$rowfrom['ground_1'];
        }
        while ($rowto = mysqli_fetch_array($toq)) {
            $r3s=$rowto['short_3'];
            $r1g=$rowto['ground_1'];
        }
        $test=0;
        $obj=new Obj_json;//encapsulate all information to obj
        $obj->name=$row["t"];
        $obj->from=$_POST["first"];
        $obj->lineid=$row["lineid"];
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
        array_push($objArray,$obj);//store in objarray
    }
    echo json_encode($objArray);//echo in json
}





if ($_POST["first"]==null){

}else{
    //echo "<h1>電驛標置設定計算結果</h1>";
    readData();
}
?>
