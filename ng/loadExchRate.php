<?php
 	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include("db.php");
	$result = $conn->query("SELECT key_code FROM tbl_sysdata WHERE key_type='exrate'");  									
		$outp = "";
		while($rs = $result->fetch_array(MYSQLI_ASSOC))
		{
		    if ($outp != "") {$outp .= ",";}	    		    		  
		    $outp .= '{"exRate":"'  . $rs["key_code"] . '"}';		    	    	    		    
		}	
		$outp ='{"records":['.$outp.']}';
	$conn->close();
	echo($outp);			
	
?>