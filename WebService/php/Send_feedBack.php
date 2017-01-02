<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$suggestion = $obj['value'];
$id_person = $obj['id_person'];
//$id_person = "1";
$registration_date = date("y-m-d H:i:s");

if (strcmp ($user_key ,"key") == 0) {
	$db = openConection();
	$result = $db->query("INSERT INTO tbl_suggestions(suggestion,registration_date,id_person,email) VALUES ('".$suggestion."','".$registration_date."','".$id_person."','".$email."')");
	$json = array();
	if ($result) {
   		$json["items"]["id"] = $db->insert_id ;
   		echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();
}
?>