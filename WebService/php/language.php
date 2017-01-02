<?php
//header ('Content-type: text/html; charset=utf-8');
include '../conection.php';
$obj = json_decode(file_get_contents("php://input"), true);
//$user_key = $obj['key'];
$user_key = "key";
if ($user_key == "key") {
	$db = openConection();
	$result = $db->query("SELECT id_language,language,language_code FROM tbl_language");
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json['items'][]=$row;
	    }
	     $result->close();
	     $db->next_result();
	     echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	
	$db->close();
}
?>