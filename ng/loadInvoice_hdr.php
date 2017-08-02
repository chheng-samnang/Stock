<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include("db.php");
	$inv_id = $_GET['inv_id'];				
	if($inv_id=="")
	{					
		$result = $conn->query("
			SELECT hdr.*,cus.per_name FROM tbl_invoice_hdr AS hdr 			
			INNER JOIN tbl_person AS cus ON hdr.per_id=cus.per_id										
			WHERE inv_hdr_status=0 AND cus.per_type='customer'		
			ORDER BY hdr.inv_hdr_id DESC");
		$outp = "";
		while($rs = $result->fetch_array(MYSQLI_ASSOC))
		{
		    if ($outp != "") {$outp .= ",";}	    
		    $outp .= '{"cus_name":"'  . $rs["per_name"] . '",';
		    $outp .= '"date":"'  . $rs["inv_hdr_date"] . '",';	
		    $outp .= '"no":"'  . $rs["inv_no"] . '",';
		    $outp .= '"account":"'  . $rs["user_crea"] . '",';	    		    	    	    
		    $outp .= '"hdr_id":"'. $rs["inv_hdr_id"]. '"}'; 
		}		
	}
	else
	{						
		$result = $conn->query("
			SELECT pro.*,MAX(pch.pch_price_out_usd) AS price_usd,MAX(pch.pch_price_out_riel) AS price_riel FROM tbl_product AS pro 
			INNER JOIN tbl_category AS cat ON pro.cat_id=cat.cat_id
			INNER JOIN tbl_purchase_det AS pch ON pro.pro_id=pch.pro_id
			INNER JOIN tbl_purchase_hdr AS hdr ON pch.pch_id=hdr.pch_id
			WHERE cat.cat_id='{$cat_id}' AND pro_status=1 AND pch_status=1
			GROUP BY pch.pro_id
			ORDER BY pro.pro_name ASC");		
		$outp = "";
		while($rs = $result->fetch_array(MYSQLI_ASSOC))
		{
		    if ($outp != "") {$outp .= ",";}	    
		    $outp .= '{"image":"'  . $rs["pro_image"] . '",';
		    $outp .= '"name":"'  . $rs["pro_name"] . '",';
		    $outp .= '"price_usd":"'  . $rs["price_usd"] . '",';
		    $outp .= '"price_riel":"'  . $rs["price_riel"] . '",';		    	    
		    $outp .= '"id":"'. $rs["pro_id"]. '"}'; 
		}
	}
	$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);		
	
?>