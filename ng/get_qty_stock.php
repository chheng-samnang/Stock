<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	include_once("db.php");
	$id = $_GET['id'];
	$result = $conn->query("
			SELECT pro_name,SUM(det.pch_qty) AS qty
			FROM  tbl_purchase_det AS det 
			INNER JOIN tbl_product AS pro ON det.pro_id=pro.pro_id
			INNER JOIN tbl_purchase_hdr AS hdr ON det.pch_id=hdr.pch_id 
			WHERE det.pro_id='{$id}' AND pch_status=1
			GROUP BY det.pro_id");
		$outp = "";
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		    if ($outp != "") {$outp .= ",";}
		    $outp .= '{"name":"'  . $rs["pro_name"] . '",';	    	    
		    $outp .= '"quantity":"'  . $rs["qty"] . '"}';	    
			}
	$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);
?>
