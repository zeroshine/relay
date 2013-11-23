<?php

class Cable {
	//declare variables
	var $from;
	var $to;
	var $length;
	var $turns;
	var $r1;
	var $x1;
	var $r0;
	var $x0;
	var $b1;
	var $b0;
	var $rm0;
	var $xm0;
	var $bm0;
	var $r1_2;
	var $x1_2;
	var $r0_2;
	var $x0_2;
	var $b1_2;
	var $b0_2;
		
	function setCableInfo($row) {
		$this->from = $row['f'];
		$this->to = $row['t'];
		$this->length = $row['lenth'];
		$this->turns = $row['ckt'];
		$this->r1 = $row['R1'];
		$this->x1 = $row['X1'];
		$this->r0 = $row['R0'];
		$this->x0 = $row['X0'];
		$this->b1 = $row['B1'];
		$this->b0 = $row['B0'];
		$this->rm0 = $row['RM0'];
		$this->xm0 = $row['XM0'];
		$this->bm0 = $row['BM0'];
		$this->r1_2 = $row['R1d'];
		$this->x1_2 = $row['X1d'];
		$this->r0_2 = $row['R0d'];
		$this->x0_2 = $row['X0d'];
		$this->b1_2 = $row['B1d'];
		$this->b0_2 = $row['B0d'];
	}
	
	function getCableInfo() {
		$arr = array(
			'from' => $this->from,
			'to' => $this->to,
			'length' => $this->length,
			'turns' => $this->turns,
			'r1' => $this->r1,
			'x1' => $this->x1,
			'r0' => $this->r0,
			'x0' => $this->x0,
			'b1' => $this->b1,
			'b0' => $this->b0,
			'rm0' => $this->rm0,
			'bm0' => $this->bm0,
			'r1_2' => $this->r1_2,
			'x1_2' => $this->x1_2,
			'r0_2' => $this->r0_2,
			'x0_2' => $this->x0_2,
			'b1_2' => $this->b1_2,
			'b0_2' => $this->b0_2	
		);
		return json_encode($arr);
	}
}

class CableTree {
	var $zone1;
	var $zone2 = array();
	
	function setZone1($zone1){
		$this->zone1 = $zone1;
	}
	
	function setZone2($zone2){
		array_push($this->zone2,$zone2);
	}
	
	function getCableTree(){
		$arr = array(
			'zone1' => $this->zone1,
			'zone2' => $this->zone2
		);
		return json_encode($arr);
	}
}

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

 $cable_tree_array_1 = array();
 $cable_tree_array_2 = array();
	
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
 
 $cable_origin = new Cable;
 $cable_origin->setCableInfo($row);
  
  while ($row = mysql_fetch_array($firstzone1)) {
  
  $cable_tree = new CableTree;     
  $zone1 = new Cable;
  $zone1->setCableInfo($row);
  $cable_tree->setZone1($zone1);
  
  $zone2start=$row['f'];
  $zone2end=$row['t'];
  
  if($row['f']===$_POST['first']){
    $zone2start=$row['t'];
    $zone2end=$row['f'];
  }

  $firstzone2 = mysql_query("SELECT * FROM ".$_POST['kv']." where (f=\"".$zone2start."\" and t!=\"".$zone2end."\") or (t=\"".$zone2start."\" and f!=\"".$zone2end."\");");
  
  while ($row2 = mysql_fetch_array($firstzone2)) {	
	$zone2 = new Cable;
	$zone2->setCableInfo($row2);
	$cable_tree->setZone2($zone2);
  }
  array_push($cable_tree_array_1, $cable_tree);
  
}

	while ($row = mysql_fetch_array($tozone1)) {

	  $cable_tree = new CableTree;     
	  $zone1 = new Cable;
	  $zone1->setCableInfo($row);
	  $cable_tree->setZone1($zone1);

	  $zone2start=$row['f'];
	  $zone2end=$row['t'];
	  
	  if($row['f']===$_POST['to']){
		$zone2start=$row['t'];
		$zone2end=$row['f'];
	  }
	  
	  $firstzone2 = mysql_query("SELECT * FROM ".$_POST['kv']." where (f=\"".$zone2start."\" and t!=\"".$zone2end."\") or (t=\"".$zone2start."\" and f!=\"".$zone2end."\");");
	  while ($row2 = mysql_fetch_array($firstzone2)) {
		
		$zone2 = new Cable;
		$zone2->setCableInfo($row2);
		$cable_tree->setZone2($zone2);

	  }
	  array_push($cable_tree_array_2, $cable_tree);
	}
	$full_cable_tree = array(
		"origin" => $cable_origin,
		"from_A" => $cable_tree_array_1,
		"from_B" => $cable_tree_array_2
	);
	//print_r($full_cable_tree);
	return $full_cable_tree;
}
if ($_POST["first"] == null || $_POST["to"] == null){
	$arr = array(
		'index' => false,
		'data' => null
	);
	//return $arr; 
	echo json_encode($arr);
}else{
	$arr = array(
		'index' => true,
		'data' => printdata()
	);
	//return $arr;
	echo json_encode($arr);
}

?>
