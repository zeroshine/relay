<?php
function recursiveRead($name,$id,&$arr,&$objArray){
    //echo $obj->to." ".$origin->from."\n";
    if(substr($name,-2,-1)!='#' ||substr($name,-3,-2)!='#'){
        //readData($name,$objArray);
        $result = array();
        array_push($result, $name);
        array_push($result, $id);
        array_push($arr,$result);
        if(!in_array($name, $objArray)){
            array_push($objArray,$name);
        }
        // echo $name."\n";
        return;
    }
    $result=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE ((f=\"".$name."\" and id!=\"".$id."\" ) 
        or (t=\"".$name."\" and id!=\"".$id."\")) and break=1;");
    while ($row1 = mysqli_fetch_array($result)){
        if($row1['f']!=$name){
            $tmp=$row1['f'];
            $row1["f"]=$row1["t"];
            $row1["t"]=$tmp;
        }
        // echo $row1["f"]." ".$row1["t"]."recursive\n";
        recursiveRead($row1['t'],$row1['id'],$arr,$objArray);
    }

}

function diff(){
    $con = mysqli_connect("localhost","relay","lab228","relay");
    if (!$con){
        die('Could not connect: ' . mysqli_error());
    }

// mysqli_select_db("relay",$con);
    mysqli_query($con,"SET NAMES 'utf8'"); 
    mysqli_query($con,"SET CHARACTER_SET_CLIENT=utf8"); 
    mysqli_query($con,"SET CHARACTER_SET_RESULTS=utf8");
	$dresult=mysqli_query($con,"SELECT 161kv_new.* FROM 161kv_new
	Left JOIN 161kv ON 161kv.id = 161kv_new.id
	WHERE 161kv.f!=161kv_new.f 
	or 161kv.t!=161kv_new.t 
	or 161kv.lineid!=161kv_new.lineid 
	or 161kv.cap!=161kv_new.cap 
	or 161kv.length!=161kv_new.length 
	or 161kv.R1!=161kv_new.R1 
	or 161kv.X1!=161kv_new.X1 
	or 161kv.R0!=161kv_new.R0 
	or 161kv.X0!=161kv_new.X0
	or 161kv.id is NULL
	");//select the different cable
    $objArray=array();
	while($row=mysqli_fetch_array($dresult)){
        // echo $row['f']." ".$row['t']."\n";
		$arr=array();
        recursiveRead($row['f'],$row['id'],$arr,$objArray);
        foreach ($arr as $result) {
		    $f1=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$result[0]."\" and id !=\"".$result[1]."\")
			 or (t=\"".$result[0]."\" and id !=\"".$result[1]."\")
			 and break=1");//select zone1 in f
    		while ($row1=mysqli_fetch_array($f1)) {
    			if($row1["f"]!=$result[0]){//let cable from end are the same
                	$tmp=$row1["f"];
                	$row1["f"]=$row1["t"];
                	$row1["t"]=$tmp;
            	}
            	$arr1=array();
                recursiveRead($row1['t'],$row1['id'],$arr1,$objArray);//jump tap point and save the name in objarray
                foreach ($arr1 as $result1) {
            	    $f2=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$result1[0]."\" and id !=\"".$result1[1]."\")
    			     or (t=\"".$result1[0]."\" and id !=\"".$result1[1]."\")
    			     and break=1");//select zone2
                    while ($row2=mysqli_fetch_array($f2)) {
                        if($row2["f"]!=$result[0]){
                            $tmp=$row2["f"];
                            $row2["f"]=$row2["t"];
                            $row2["t"]=$tmp;
                        }
                        $arr2=array();
                        recursiveRead($row2['t'],$row2['id'],$arr2,$objArray);//jump tap point and save in objarray
                    }
                }	
    		}
        }
		$arr=array();//do the same thing in to-end
        recursiveRead($row['t'],$row['id'],$arr,$objArray);
        foreach ($arr as $result) {
            $f1=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$result[0]."\" and id !=\"".$result[1]."\")
             or (t=\"".$result[0]."\" and id !=\"".$result[1]."\")
             and break=1");
            while ($row1=mysqli_fetch_array($f1)) {
                if($row1["f"]!=$result[0]){
                    $tmp=$row1["f"];
                    $row1["f"]=$row1["t"];
                    $row1["t"]=$tmp;
                }
                $arr1=array();
                recursiveRead($row1['t'],$row1['id'],$arr1,$objArray);
                foreach ($arr1 as $result1) {
                    $f2=mysqli_query($con,"SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$result1[0]."\" and id !=\"".$result1[1]."\")
                     or (t=\"".$result1[0]."\" and id !=\"".$result1[1]."\")
                     and break=1");
                    // echo "SELECT * FROM ".$_POST['kv']." WHERE (f=\"".$result1[0]."\" id !=\"".$result1[1]."\")
                    //  or (t=\"".$result1[0]."\" and id !=\"".$result1[1]."\")
                    //  and break=1";
                    while ($row2=mysqli_fetch_array($f2)) {
                        if($row2["f"]!=$result[0]){
                            $tmp=$row2["f"];
                            $row2["f"]=$row2["t"];
                            $row2["t"]=$tmp;
                        }
                        $arr2=array();
                        recursiveRead($row2['t'],$row2['id'],$arr2,$objArray);
                    }
                }   
            }
        }

	}
    echo json_encode($objArray);        

}

diff(); 

?>