<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include("db.php");
	$id = $_GET['id'];						
	$result = $conn->query("
			SELECT pro.*,MAX(pch.pch_price_out_usd) AS price_usd,MAX(pch.pch_price_out_riel) AS price_riel,SUM(pch_qty) AS qty FROM tbl_product AS pro		
			INNER JOIN tbl_purchase_det AS pch ON pro.pro_id=pch.pro_id
			INNER JOIN tbl_purchase_hdr AS hdr ON pch.pch_id=hdr.pch_id			
			WHERE pro.pro_id='{$id}' AND pro_status=1 AND pch_status=1");		
		$outp = "";
		while($rs = $result->fetch_array(MYSQLI_ASSOC))
		{
		    if ($outp != "") {$outp .= ",";}	    
		    $outp .= '{"product":"'  . $rs["pro_name"] . '",';
		    $outp .= '"qty":"'  . $rs["qty"] . '",';
		    $outp .= '"price_usd":"'  . $rs["price_usd"] . '",';
		     $outp .= '"price_riel":"'  . $rs["price_riel"] . '",';
		    $outp .= '"id":"'  . $rs["pro_id"] . '"}';
		     
		}

	$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);		
	
?>