<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include("db.php");
	$id = $_GET['id'];				
						
	$result = $conn->query("SELECT * FROM tbl_person WHERE per_type='customer' AND per_id='{$id}'");					
	$outp = "";
	while($rs = $result->fetch_array(MYSQLI_ASSOC))
	{
	    if ($outp != "") {$outp .= ",";}	    		    		  
	    $outp .= '{"cust_name":"'  . $rs["per_name"] . '",';	    	    
	    $outp .= '"cust_id":"'  . $rs["per_id"] . '"}'; 
	}	
	$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);		
	
?>