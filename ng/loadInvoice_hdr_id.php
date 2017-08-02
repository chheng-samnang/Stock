<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include("db.php");
	$inv_id = $_GET['inv_id'];				
						
	$result = $conn->query("
		SELECT det.*,pro.* FROM tbl_invoice_detail AS det
		INNER JOIN tbl_product AS pro ON det.pro_id=pro.pro_id			
		WHERE inv_hdr_id='{$inv_id}'			
		ORDER BY pro.pro_name ASC");		
	$outp = "";
	while($rs = $result->fetch_array(MYSQLI_ASSOC))
	{
	    if ($outp != "") {$outp .= ",";}	    		    		  
	    $outp .= '{"product":"'  . $rs["pro_name"] . '",';
	    $outp .= '"qty":"'  . $rs["qty"] . '",';
	    $outp .= '"price_usd":"'  . $rs["price_usd"] . '",';	    
	    $outp .= '"price_riel":"'  . $rs["price_riel"] . '"}'; 
	}	

	$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);		
	
?>